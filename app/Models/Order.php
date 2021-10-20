<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'provider_id','status','order_date','order_id','customer_name','customer_phone','customer_email','amount','invoice_date','invoice_id'
    ];


    public function provider(){
        return $this->hasOne(Provider::class,'id','provider_id');
    }

    public function order_products(){
        return $this->hasMany(OrderProduct::class,'order_id','id');

    }

//    public function customer(){
//         return $this->hasOne(Customer::class,'customer_id','id');
//    }
}
