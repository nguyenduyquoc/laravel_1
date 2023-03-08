<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function list(){
        $data_order = Order::orderBy("id", "desc")->paginate(20);
        return view("admin.order.list", compact('data_order'));
    }

    public function detail(Order $order){
        return view("admin.order.detail", compact("order"));
    }

    public function updateStatus(Order $order, Request $request){
        $order->status= $request->status;
        $order->save();
        return redirect()->to(url("admin/order/detail", ["order"=>$order->id]));
    }
}
