<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';

    protected $fillable = [
        "name",
        "thumbnail",
        "price",
        "quantity",
        "description",
        "unit",
        "status",
        "category_id"
    ];

    public function Category(){
        return $this->belongsTo(Category::class);
    }
    public function Orders(){
        return $this->belongsToMany(Order::class,"order_products")->withPivot('quantity', 'price');
    }

    // hàm tìm kiếm theo tên trong list_product
    public function scopeSearch($query,$search){
        if($search && $search != ""){
            return $query->where("name","like","%$search%");
        }
        return $query;
    }

    // hàm tìm kiếm theo tên Category của product đó
    public function scopeCategoryFiler($query,$category_id){
        if($category_id && $category_id != 0){
            return $query->where("category_id",$category_id);
        }
        return $query;
    }


    // hàm tìm kiếm theo giá tiền trong một đoạn nào đó
    public function scopeMinPrice($query, $minprice){
        if($minprice && $minprice != 0){
            return $query->where("price", ">=", $minprice);
        }
        return $query;
    }


    //  hàm tìm kiếm theo giá tiền trong một đoạn nào đó
    public function scopeMaxPrice($query, $maxprice){
        if($maxprice && $maxprice != 0){
            return $query->where("price", "<=", $maxprice);
        }
        return $query;
    }
}
