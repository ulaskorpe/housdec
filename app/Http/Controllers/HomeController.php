<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Admin;
use App\Models\City;
use App\Models\District;
use App\Models\Locality;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){




/*
        $distincts = District::with('city')->get();



        foreach ($distincts as $distinct){
            echo $distinct->city()->first()->name.":".$distinct['name']."<br>";
        }
*/
    }
    public function checkImage($image)
    {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = GeneralHelper::findExtension($image);
        //echo $ext;

        if (in_array($ext, $allowed)) {
            return "ok";
        } else {
            return 0;
        }
    }

    public function generatePassword(){
        return GeneralHelper::randomPassword(8,1);
    }

    public function cities(){
        $city = City::with('districts')->where('id','=',13)->first();

        $distinct = District::with('city')->where('id','=',1106)->first();

        return $distinct;
    }

}
