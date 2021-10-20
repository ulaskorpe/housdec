<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Symfony\Component\Translation\t;

class District extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'districts';
    protected $fillable = [
       'id', 'name','slug','type','latitude','longitude','city_id'
    ];


    public function city(){
        return $this->hasOne(City::class,'id','city_id');
    }

    public function localities(){
        return $this->hasMany(Locality::class,'district_id','id')->orderBy('name');
    }
}
