<?php


namespace App\Http\Controllers;


use App\Enums\LangType;
use App\Enums\ResultType;
use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Setting;
use App\Models\Tmp;
use App\Models\User;
use App\Models\UserFollower;
use App\Models\UserKey;
use App\Models\UserPin;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Symfony\Component\Translation\t;
use Twilio\Rest\Client;


trait ApiTrait
{


    private function lastSeen($mins){

        if($mins <= 1){

            $last = __('general.now');
        }elseif ($mins > 1 && $mins<60){

            $last = $mins." ".__('general.mins');
        }elseif ($mins >= 60 && $mins<1440){
            $hour = floor($mins / 60);
            $min = $mins - ($hour*60);
            $hour = ($min>= 30) ? ($hour+1) : $hour;
            if($hour==24){
                $last =  "1 ".__('general.day') ;
            }else{
                $last =  $hour." ".__('general.hour') ;
            }

        }elseif ($mins >= 1440 && $mins<43200){

            $day =floor($mins / 1440);
            // $min = floor(($mins - ($day * 1440)) / 60);
            $min =  ($mins - ($day * 1440)) ;
            $day = ($min >= 720 ) ? $day+1 : $day;
            if($day == 30){
                $last=  "1 ".__('general.month') ;

            }else{
                $last= $day." ".__('general.day') ;
            }

        }elseif ($mins >= 43200 && $mins < 525600 ){


            $month = floor($mins/43200);
            $min = $mins - ($month * 43200);
            $days = round($min/1440);

            if($days==30){
                $last= ($month+1)." ".__('general.month')." ".__('general.ago');
            }else{
                if($days>0){
                    $last= $month." ".__('general.month')." ".$days." ".__('general.day')." ".__('general.ago');
                }else{
                    $last= $month." ".__('general.month')." ".__('general.ago');
                }
            }
            ///

        }else{
            $last = __('general.more_than_a_year');
        }

        return $last;
    }


    private function validate_phone($phone){

        // Your Account Sid and Auth Token from twilio.com/user/account
        $sid = env('TWILIO_ID');//"AC676b657d3c7c7c594ca1118d3d54b311"; // Your Account SID from www.twilio.com/console
        $token = env('TWILIO_TOKEN'); //"f6bd4982d673b54d79e99ebe6bfe4480"; // Your Auth Token from www.twilio.com/console

        $client = new Lookups_Services_Twilio($sid, $token);

// Perform a carrier Lookup using a US country code
        $number = $client->phone_numbers->get("(510) 867-5309", array("CountryCode" => "US", "Type" => "carrier"));

// Log the carrier type and name
        echo $number->carrier->type . "\r\n"; // => mobile
        echo $number->carrier->name; // => Sprint Spectrum, L.P.

    }


    private function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool {
        return preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/', $s);
    }


    function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool {
        //remove white space, dots, hyphens and brackets
        $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

        //are we left with digits only?
        return $this->isDigits($telephone, $minDigits, $maxDigits);
    }


   private function validate_phone_number($phone,$country_code=90)
    {


        $co = Country::where('phonecode','=',$country_code)->first();
            if(empty($co['id'])){
                return false;
            }else{
                // Allow +, - and . in phone number
                $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
                // Remove "-" from number
                $phone_to_check = str_replace("-", "", $filtered_phone_number);
                // Check the lenght of number
                // This can be customized if you want phone number from a specific country

              /*  if(in_array($co['phonecode'],[49,90])){
                    return $this->isValidTelephoneNumber($phone_to_check,10,11);
                }else{
                    return $this->isValidTelephoneNumber($phone_to_check);
                }*/
                return $this->isValidTelephoneNumber($phone_to_check);
            }


        /*    if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
                    return false;
             } else {

                return true;
             }

*/
       // return true;



           // return true;
     /*       if((int)$phone_to_check>1999999999 || (int)$phone_to_check<9000000000){
                return true;
            }else{
                return true;
            }*/


    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    private function sendSMS($msg,$number,$signature=false){
        $sid = env('TWILIO_ID');//"AC676b657d3c7c7c594ca1118d3d54b311"; // Your Account SID from www.twilio.com/console
        $token = env('TWILIO_TOKEN'); //"f6bd4982d673b54d79e99ebe6bfe4480"; // Your Auth Token from www.twilio.com/console
        $msg  = ($signature == false)? $msg : $msg."\n".env('APP_SIGNATURE');
        $client = new Client($sid,$token);
        $message = $client->messages->create(
            '+'.$number, // Text this number
            [
                'from' => env('MessagingServiceID'), // From a valid Twilio number

                'body' => $msg
            ]
        );

        return $message;
    }

    private function distance($lat1, $lon1, $lat2, $lon2) {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;
        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;
//echo ' '.$km;
        return $km*1000; ///metre
    }


    private  function generateKey(){
        return md5('pingApp_prothelis_2020');
    }

    private function checkUnique($field,$table,$value){
        $ch = DB::table($table)
            ->select('id')
            ->whereRaw($field.'= ?',[$value])->first();
        return (!empty($ch->id)) ? 1:0;
    }

    private function setLang($lang = 'en'){
        $lang_array = LangType::asArray();
        $lang = (in_array($lang, $lang_array)) ? $lang : 'en';
        Session::put('lang',$lang);
        App::setLocale($lang);
        //return $lang;

    }

    private function whois($user_id){
        $user =  Admin::find($user_id);
        return $user;
    }

    private $langArray =  ['tr'=>'Türkçe','en'=>'English','de'=>'Deutsch'];
    private $typeArray =  ['about_us','faq'];


    private function generatePin($user,$via='phone'){

        $userPin=UserPin::where('user_id','=',$user['id'])->where('token','=',$user['token'])->first();
        if(!empty($userPin['id'])){
            $userPin->delete();

        }
        $pin = "";
        $ch = true;
        while( $ch){
            $pin = rand(100000,999999);
            $ch = ($this->checkUnique('pin','user_pin',$pin))? true : false;
        }

        $userPin = new UserPin();
        $userPin->user_id = $user['id'];
        $userPin->token = $user['token'];
        $userPin->pin = $pin;
        $userPin->via = $via;
        $userPin->save();

        return $pin;
    }

    private function sendnotification($to,$msg,$title,$img,$type='standart',$data=null)
    {

        ///$to = 'cf3dd778-a5dc-4589-95bb-cd894785e295';
        //$msg = 'deneme mesajı';
        $img = (!empty($img))?$img:'';//"https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png";
        $content = array(
            "en" => $msg
        );
        $headings = array(
            "en" =>(!empty($title))?$title:date('YmdHi')
        );
        // if ($img == '') {


        if(empty($data)){
            $data = ['type' =>(!empty($type))?$type:'standart'];
        }


        //        $data_array = json_decode($data,true);
//        $tmp = new Tmp();
//        $tmp->data = $type.'apiTrait';
//        $tmp->text = json_encode($data);
//        $tmp->save();


        $fields = array(
                'app_id' => env('ONESIGNAL_APP_ID'),
                "headings" => $headings,
                'include_player_ids' => array($to),
                'large_icon' => $img,
                'content_available' => true,
                'contents' => $content,
                'type'=>$type,
                'data'=> $data

            );
//        if(true){
//        } else {
//            $ios_img = array(
//                "id1" => $img
//            );
//            $fields = array(
//                'app_id' => 'YOUR_APP_ID',
//                "headings" => $headings,
//                'include_player_ids' => array($to),
//                'contents' => $content,
//                "big_picture" => $img,
//                'large_icon' => "https://www.google.co.in/images/branding/googleg/1x/googleg_standard_color_128dp.png",
//                'content_available' => true,
//                "ios_attachments" => $ios_img
//            );


        $headers = array(
            'Authorization: key='.env('ONESIGNAL_APP_KEY'),
            'Content-Type: application/json; charset=utf-8'
        );





        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
         return $result;
    }


    private function findSetting($setting_key){
        $setting = Setting::select('value')->where('key','=',$setting_key)->first();
        return (!empty($setting['value']))?$setting['value']:false;
    }

//TODO ::  standartize all responses with this fx below !!!
    private function apiResponse($resultType, $data,$message=null,$code=200){

        $response = [];

        $response['success'] = ($resultType == ResultType::Success) ? true :false ;

        if(isset($data)){
            if($resultType != ResultType::Error){
                $response['data'] = $data;
            }else{
                $response['errors'] = $data;
            }
        }


        if(isset($message)){
            $response['message'] = $message;
        }

        return response()->json($response,$code);
    }


    private  function makeKey($user_id){

        $userKey = UserKey::where('user_id','=',$user_id)->where('expires','>=',date('Y-m-d H:i:s'))->first();

        if(empty($userKey)){

            $userKey = new UserKey();
            $userKey->user_id = $user_id;
            $userKey->expires = Carbon::now()->addDay(1);
            $userKey->key =strtoupper(GeneralHelper::randomPassword(6,1));
            $userKey->save();

        }

        return $userKey['key'];
    }


    private function isFollowing($user_id , $other ){
        if(!is_int($other)){
            $other = User::where('token','=',$other)->first();
            $other = $other['id'];
        }

        $follow = UserFollower::where('user_id','=',$user_id)->where('follower_id','=',$other)->first();
        if(empty($follow['id'])){
            $follow = UserFollower::where('user_id','=',$other)->where('follower_id','=',$user_id)->first();
        }

        return (!empty($follow['id']))?true:false;


    }

   private function resize_image($file, $w, $h, $url) {
       $extension = pathinfo($file, PATHINFO_EXTENSION);

       $image = imagecreatefromjpeg($file);
       $filename = $url.time().".".$extension;

       $thumb_width = $w;
       $thumb_height = $h;

       $width = imagesx($image);
       $height = imagesy($image);

       $original_aspect = $width / $height;
       $thumb_aspect = $thumb_width / $thumb_height;

       if ( $original_aspect >= $thumb_aspect )
       {
           // If image is wider than thumbnail (in aspect ratio sense)
           $new_height = $thumb_height;
           $new_width = $width / ($height / $thumb_height);
       }
       else
       {
           // If the thumbnail is wider than the image
           $new_width = $thumb_width;
           $new_height = $height / ($width / $thumb_width);
       }

       $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

// Resize and crop
       imagecopyresampled($thumb,
           $image,
           0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
           0 - ($new_height - $thumb_height) / 2, // Center the image vertically
           0, 0,
           $new_width, $new_height,
           $width, $height);
       imagejpeg($thumb, $filename, 80);

        return $filename;
    }


    private function makeTmp($data=null , $txt = null){
        $tmp = new Tmp();
        $tmp->data = ($data == null ) ? date('Y-m-d H:i:s'): $data;
        $tmp->text = ($txt == null)? "":$txt;
        $tmp->save();

    }
}


