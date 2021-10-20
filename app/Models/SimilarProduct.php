<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimilarProduct extends Model
{
    use HasFactory;

    protected $table = 'similar_products';
    protected $fillable = [
        'product_id','similar_id','order'
    ];
    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function similar_product(){
        return $this->hasOne(Product::class,'id','similar_id');
    }
}
