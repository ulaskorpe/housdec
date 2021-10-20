<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $table = 'admins';
    protected $fillable = [
        'email','password','name_surname','phone','avatar','sudo','active','lang'
    ];

}
