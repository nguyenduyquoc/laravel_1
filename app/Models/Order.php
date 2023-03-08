<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";

    protected $fillable = [
        "grand_total",
        "status",
        "shipping_address",
        "customer_tel",
        "fullname",
        "country",
        "state",
        "city",
        "postcode",
        "note",
        "email",
        "created_at",
        "payed"
    ];

    const PENDING = 0;
    const CONFIRM = 1;
    const SHIPPING = 2;
    const COMPLETE = 3;
    const CANCEL = 4;
    const REFUND = 5;



    public function Products(){
        return $this->belongsToMany(Product::class,"order_products")->withPivot('quantity', 'price');
    }
}
