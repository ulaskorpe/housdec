<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'variants';
    protected $fillable = [
        'product_id','variant','img_id'
    ];


    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function img(){
        return $this->hasOne(ProductImage::class,'id','img_id');
    }
}
