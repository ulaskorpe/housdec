<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralHelper extends Controller
{


    public static function randomPassword($len = 16,$alphabet=0) {
        if($alphabet==1){
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@';
        }else{
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890+-%/*#$%&()!@';
        }

        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    public static function findExtension($file)
    {
        $array = explode(".", $file);
        return strtolower($array[count($array) - 1]);
    }
    public static function fixName($x)
    {
        $x = trim(strtolower($x));

        //$uzanti=$this->uzantiBul($x);
        //$x=substr($x,0,(strlen($x)-(strlen($uzanti)+1)));
        $x = (str_replace("Ş", "s", $x));
        $x = (str_replace("ş", "s", $x));
        $x = (str_replace("İ", "i", $x));
        $x = (str_replace("ı", "i", $x));
        $x = (str_replace("Ç", "c", $x));
        $x = (str_replace("ç", "c", $x));
        $x = (str_replace("ğ", "g", $x));
        $x = (str_replace("Ğ", "g", $x));
        $x = (str_replace("ü", "u", $x));
        $x = (str_replace("Ü", "u", $x));
        $x = (str_replace("ö", "o", $x));
        $x = (str_replace("Ö", "o", $x));
        $x = (str_replace(".", "_", $x));
        $x = (str_replace(",", "_", $x));
        $x = (str_replace("!", "_", $x));
        $x = (str_replace("?", "_", $x));
        $x = (str_replace("/", " ", $x));
        $x = (str_replace(" ", "_", $x));
        $x = (str_replace("@", "_", $x));
        //  $x=(str_replace(" ","_",$x));
        // $x=(str_replace("_","",$x));
        $xz = "";
        for ($i = 0; $i < (strlen($x)); $i++) {
            $ord = ord(substr($x, $i, 1));
            if ((($ord >= 48) && ($ord <= 57)) || (($ord >= 65) && ($ord <= 90)) || (($ord >= 97) && ($ord <= 122)) || ($ord !=249) || ($ord!=250)) {
                $xz .= substr($x, $i, 1);
            } else {
                $xz .= "";
            }
        }

        $xz = (empty($xz)) ? "_" : $xz;
        // $xz=$xz.".".$uzanti;
        return $xz;
    }
    public static function fixNumber($x)
    {
        $x = trim(strtolower($x));
        $result = "";
        for ($i = 0; $i < (strlen($x)); $i++) {
            $ord = ord(substr($x, $i, 1));
            //    if (($ord >= 48) && ($ord <= 57)) {
            //if(1){
            $result .= substr($x, $i, 1);
            /*} else {
                $result .= "";
            }*/
        }

        if(substr($result,0,1)=="-"){
            $result=substr($result,1,strlen($result));
        }

        $result = (empty($result)) ? "" :  str_replace("++","+", $result);//intval($result);
        return $result;
    }

/*
    function makePrivateFileUrl(string $path, int $width = 0, int $height = 0, int $aspect = 0)
    {
        $parameterString = "?u=" . $path;
        if ($width > 0)
            $parameterString .= "&w=" . $width;
        if ($height > 0)
            $parameterString .= "&h=" . $height;
        // if (($width > 0 || $height > 0))
        $parameterString .= "&a=" . $aspect;
        return route("pfiles") . $parameterString;
    }


    function makeCommonFileUrl(string $path, int $width = 0, int $height = 0, int $aspect = 0)
    {
        $parameterString = "?u=" . $path;
        if ($width > 0)
            $parameterString .= "&w=" . $width;
        if ($height > 0)
            $parameterString .= "&h=" . $height;
        // if (($width > 0 || $height > 0))
        $parameterString .= "&a=" . $aspect;
        return route("get_file") . $parameterString;
    }

*/
}
