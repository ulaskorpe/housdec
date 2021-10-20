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
       'product_name','code','description','img_id','incoming','outgoing','current'
    ];


    public function variants(){
        return $this->hasMany(Variant::class,'product_id','id');
    }

    public function img(){
        return $this->hasOne(ProductImage::class,'id','img_id');
    }


    public function images(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }

}
