<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // tạo data ảo
        // \App\Models\User::factory(10)->create();
        Category::factory(100)->create();
        Product::factory(1000)->create();
        Order::factory(50)->create();


        $orders = Order::all();
        foreach ($orders as $order){
            $num = random_int(1,10);
            $products = Product::all()->random($num);
            $grand_total = 0;
            foreach ($products as $product){
                $quantity = random_int(1,20);
                $grand_total += $quantity * $product->price;
                DB::table("order_products")->insert([
                    "order_id"=> $order->id,
                    "product_id"=>$product->id,
                    "quantity"=>$quantity,
                    "price"=>$product->price
                ]);
            }
            $order->update(["grand_total"=>$grand_total]);
        }
    }
}
