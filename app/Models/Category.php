<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        "name",
        "icon",
        "status"
    ];

    public function Products(){
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($query, $search){
        if($search && $search != ""){
            return $query->where("name","like","%$search%");
        }
        return $query;
    }
}
