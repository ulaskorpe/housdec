<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locality extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'localities';
    protected $fillable = [
        'id','district_id', 'name','slug','type'
    ];


    public function district(){
        return $this->hasOne(District::class,'district_id','id');
    }
}
