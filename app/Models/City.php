<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'cities';
    protected $fillable = [
        'name','code','slug','type','latitude','longitude','country_id'
    ];


    public function districts(){
        return $this->hasMany(District::class )->orderBy('name');
    }



}
