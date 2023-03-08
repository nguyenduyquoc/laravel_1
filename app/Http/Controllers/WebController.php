<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function home(){
        $orders_count = Order::count();
        $orders_sum_grand_total = Order::sum("grand_total");
        $products_count  = Product::count();
        $total_quantity = DB::table("order_products")->sum("quantity");

        $categories_data  = Category::withCount("Products")->limit(6)->get();

        $categories_names = [];
        $category_products_counts = [];

        foreach ($categories_data as $item){
            $categories_names[] = $item->name;
            $category_products_counts[] = $item->products_count;
        }

        $categories_names = json_encode($categories_names);
        $category_products_counts = json_encode($category_products_counts);

        $today = today();
        $last7 = today()->subDay(6);
        $last6 = today()->subDay(5);
        $last5 = today()->subDay(4);
        $last4 = today()->subDay(3);
        $last3 = today()->subDay(2);
        $last2 = today()->subDay(1);

        $today_orders = Order::whereDate("created_at", $today)->count();
        $last7_orders = Order::whereDate("created_at", $last7)->count();
        $last6_orders = Order::whereDate("created_at", $last6)->count();
        $last5_orders = Order::whereDate("created_at", $last5)->count();
        $last4_orders = Order::whereDate("created_at", $last4)->count();
        $last3_orders = Order::whereDate("created_at", $last3)->count();
        $last2_orders = Order::whereDate("created_at", $last2)->count();

        // top 5 sản phẩm bán chạy nhất
        $productIds = DB::table("order_products")->groupBy("product_id")
            ->select(DB::raw("product_id, sum(quantity) as total_quantity"))
            ->orderBy("total_quantity", "desc")
            ->limit(5)
            ->get()
            ->pluck("product_id")
            ->toArray();
        $bestSellers = Product::find($productIds);


        return view("welcome", compact('orders_count', 'orders_sum_grand_total', 'products_count', 'total_quantity', 'categories_names', 'category_products_counts'));

    }
    public function aboutUs(){
        return view("about_us");
    }


}
