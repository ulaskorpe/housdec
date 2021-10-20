<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_products';
    protected $fillable = [
        'order_id','product_id','variant_id','quantity'
    ];


    public function order(){
        return $this->hasOne(Order::class,'order_id','id');
    }

    public function product(){
         return $this->hasOne(Product::class,'id','product_id');
    }

    public function variant(){
        return $this->hasOne(Variant::class,'id','variant_id');
    }
}
