<?php

namespace App\Http\Controllers;

use App\Mail\MailOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Pusher\Pusher;
use Srmklive\PayPal\Services\PayPal;

class GuestController extends Controller
{
    public function index(){

        // top 5 sản phẩm mới nhất
        $top8_new_product =Product::orderBy("created_at", "desc")
            ->limit(8)->get();
         return view("guest.home", compact("top8_new_product"));
    }

    public function detail(Product $product){
        $related_products = Product::where("category_id",$product->category_id)
            ->where('id','<>',$product->id)
            ->orderBy("created_at","desc")->limit(4)->get();
        return view("guest.guest_detail" , compact("product", "related_products"));
    }

    public function addToCart(Product $product, Request $request){
        $request->validate([
            "buy_quantity"=>"required|numeric|min:1|max:".$product->quantity
        ]);
        $buy_quantity = $request->get("buy_quantity");
        $product->buy_quantity = $buy_quantity;
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        // kiểm tra sản phẩm đã có trong giỏ hàng hay chưa
        $f = true;
        foreach ($cart as $item){
            if ($item->id == $product->id){
                $item->buy_quantity += $buy_quantity;
                $f = false;
                break;
            }
        }
        if ($f){
            $cart[] = $product;
        }
        session(["cart"=>$cart]);
        return redirect()->to("cart");

    }

    public function cart(){
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        $grand_total = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $grand_total+= $item->price * $item->buy_quantity;
            if($item->quantity < $item->buy_quantity){
                $can_checkout= false;
            }
        }
        return view("guest.cart", compact('cart','grand_total','can_checkout'));
    }

    public function removeItem(Product $product){
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        foreach ($cart as $key=>$item){
            if($item->id == $product->id){
                unset($cart[$key]);
            }
        }
        session(["cart"=>$cart]);
        return redirect()->to("cart");
    }


    public function createCheckout(){
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        $grand_total = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $grand_total+= $item->price * $item->buy_quantity;
            if($item->quantity < $item->buy_quantity){
                $can_checkout= false;
            }
        }
        if(!$can_checkout && count($cart)){
            return redirect()->to("cart");
        }
        return view("guest.checkout", compact("cart","grand_total" ));
    }

    public function placeOrder(Request $request){

        $request->validate([
            "firstname"=> "required",
            "lastname"=> "required",
            "country"=> "required",
            "shipping_address"=> "required",
            "city"=> "required",
            "state"=> "required",
            "postcode"=> "required|numeric",
            "customer_tel"=> "required",
            "email"=> "required",
        ]);
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        $grand_total = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $grand_total+= $item->price * $item->buy_quantity;
            if($item->quantity < $item->buy_quantity){
                $can_checkout= false;
            }
        }
        if(!$can_checkout && count($cart) > 0){
            return redirect()->to("cart");
        }
        $order = Order::create(
            [
                "grand_total"=> $grand_total,
                "status"=>Order::PENDING,
                "shipping_address"=>$request->get("shipping_address"),
                "customer_tel"=>$request->get("customer_tel"),
                "fullname"=>$request->get("firstname"). $request->get("lastname"),
                "country"=>$request->get("country"),
                "city"=>$request->get("city"),
                "state"=>$request->get("state"),
                "postcode"=>$request->get("postcode"),
                "email"=>$request->get("email"),
                "note"=>$request->get("note"),
            ]
        );

        foreach ($cart as $item){
            DB::table("order_products")->insert([
                "order_id"=>$order->id,
                "product_id"=>$item->id,
                "quantity"=>$item->buy_quantity,
                "price"=>$item->price
            ]);
            $item->decrement("quantity",$item->buy_quantity);
        }
    session()->forget("cart");

 //       notification pusher
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            'd18ade0f6d4c2c61e28b',
            '4e17cbb1a490c4fbce86',
            '1562989',
            $options
        );

        $data['message'] = 'Có một đơn hàng mới, bạn có muốn tải lại trang?';
        $data["confirm"] = true;
        $pusher->trigger('my-channel', 'my-event', $data);

        Mail::to($order->email)->send(new MailOrder($order));
        // to  checkout-success
        if($request->get("payment") == "paypal"){
            return redirect()->route("process_paypal",["order"=>$order->id]);
        }
        return redirect()->to("thankyou_card");

    }
    public function processPaypal(Order $order){
        $provider = new Paypal;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success_paypal', ['order'=>$order->id]),
                "cancel_url" => route('cancel_paypal', ['order'=>$order->id]),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format("$order->grand_total", 2,".","")
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

        }
        return "Có sự cố xảy ra trong quá trình thanh toán, vui lòng thanh toán lại sau.";
    }


    public function successPaypal(Order $order){
        $order->update(["payed"=>true]);
        if($order->status == Order::PENDING){
            $order->update(["status"=>Order::CONFIRM]);
        }
        return redirect()->to("thankyou_card");
    }
    public function cancelPaypal(Order $order){
        return redirect()->to("cart");
    }

    public function thankyouCard(){
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        $grand_total = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $grand_total+= $item->price * $item->buy_quantity;
            if($item->quantity < $item->buy_quantity){
                $can_checkout= false;
            }
        }
        return view("guest.thankyou_card", compact('cart'));
    }

    public function orderDetail(){
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        $grand_total = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $grand_total+= $item->price * $item->buy_quantity;
            if($item->quantity < $item->buy_quantity){
                $can_checkout= false;
            }
        }
        return view("guest.order_detail", compact('cart','grand_total','can_checkout'));
    }
}
