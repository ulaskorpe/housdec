<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stocks';
    protected $fillable = [
       'product_id','variant_id','incoming','outgoing','order_id'
    ];

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }
    public function variant(){
        return $this->hasOne(Variant::class,'id','variant_id');
    }
}
