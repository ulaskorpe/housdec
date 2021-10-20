<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_images';
    protected $fillable = [
        'product_id','variant_id','thumb','image','count'
    ];




    public function product(){
        return $this->hasOne(Product::class,'product_id','id');
    }

    public function variant(){
        return $this->hasOne(Variant::class,'id','variant_id');
    }
}
