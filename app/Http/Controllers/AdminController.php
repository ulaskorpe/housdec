<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Admin;
use App\Models\Calendar;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    use ApiTrait;

    public function getPic(){
        $admin = $this->whois(Session::get('admin_id'));
        return (!empty($admin['avatar']))?url($admin['avatar']):url('images/avatar.png');
    }

    public function logout(){

        Session::put('admin_id',null);

        Session::put('sudo',null);

        return redirect(route('admin-index'));
    }

    public function index(){

        //Session::put('admin_id',null);

        //Session::put('sudo',null);

        $data=array();

        $this->setLang('tr');

        if(Session::get('admin_id')){
            $data['who'] = $this->whois(Session::get('admin_id'));

            /// $data['articles']=Article::all();
            $dates = Calendar::where('date','<=',date("Y-m-d"))
                ->where('date','>=','2020-06-19')
                ->pluck('date')->toArray();
            $user_count = 0;
            /*    $data['users'] = array();
                foreach ($dates as $date){
                    $count = User::where('created_at','>=',$date." 00:00:00")
                        ->where('created_at','<=',$date." 23:59:59")
                        ->count();
                    $data['users'][]=[$date,$count];
                    $user_count +=$count;
                }*/
            $data['total_order'] = Order::count();
            $data['total_amount'] = Order::sum('amount');

            $data['user_count'] =$user_count;


            $data['dates']=$dates;
            $data['orders']=Order::with('provider','order_products.product','order_products.variant')->orderBy('id','DESC')->get();

/*
            foreach ($data['orders'] as $order){
                foreach ($order->order_products as $product){
                    echo $product->product()->first()->product_name;
                }
            }

            return  "ok";*/
         //   dd($data['orders']);
            $data['badges'] = [1=>['badge-success','Hazırlanıyor']
                ,2=>['badge-completed','Tamamlandı'],3=>['badge-danger','İptal Edildi']];
          //  return $badges[3][1];
            return view('index',$data);
            //return view('admin_panel.home',$data);
        }else{
            return view('login',$data);
            //return view('admin.main_index',$data);
        }

        //$data['admins']=Admin::all();




    }

    public function adminList(){
        //Session::put('admin_id',null);

        //Session::put('sudo',null);

        $data=array();

        $this->setLang('tr');


            $data['who'] = $this->whois(Session::get('admin_id'));

            $data['admins']=Admin::all();


            return view('admin.list',$data);
            //return view('admin_panel.home',$data);






    }

    public function createAdmin (){
       return view('admin.create');
    }

    public function updateAdmin ($id){

       return view('admin.update',['admin'=>Admin::find($id)]);
    }

    public function profile(){

    $data=array();
    $data['admin']=Admin::find(Session::get('admin_id'));
        return view('profile',$data);
    }

    public function createAdminPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $admin = new Admin();
                $admin->name_surname = $request['name_surname'];
                $admin->email = $request['email'];
                $admin->phone = (!empty($request['phone'])) ? $request['phone'] :"";

                $file = $request->file('avatar');
                if (!empty($file)) {

                   // return $request->file('avatar')->getClientOriginalName();

                    $path = public_path("images/admins/" . $admin->id);
                    $filename = GeneralHelper::fixName($request['name_surname']) . "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                    $file->move($path, $filename);
                    $admin->avatar = "images/admins/" . $admin->id . "/" . $filename;

                }

                $admin->password= md5($request['password']);
                $admin->sudo = (!empty($request['sudo']))?1:0;
                $admin->active = (!empty($request['active']))?1:0;
                $admin->lang = (!empty($request['lang']))?$request['lang']:'tr';

                $admin->save();
                return [ 'Admin Eklendi', 'success', route('admin-list'),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }

    public function updateAdminPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $admin = Admin::find($request['id']);
                $admin->name_surname = $request['name_surname'];
                $admin->email = $request['email'];
                $admin->phone = (!empty($request['phone'])) ? $request['phone'] :"";

                $file = $request->file('avatar');
                if (!empty($file)) {

                   // return $request->file('avatar')->getClientOriginalName();

                    $path = public_path("images/admins/" . $admin->id);
                    $filename = GeneralHelper::fixName($request['name_surname']) . "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                    $file->move($path, $filename);
                    $admin->avatar = "images/admins/" . $admin->id . "/" . $filename;

                }

                if(!empty($request['password'])) {
                    $admin->password = md5($request['password']);
                }
                $admin->sudo = (!empty($request['sudo']))?1:0;
                $admin->active = (!empty($request['active']))?1:0;
                $admin->lang = (!empty($request['lang']))?$request['lang']:'tr';

                $admin->save();
                return [ 'Admin Güncellendi', 'success', route('admin-list'),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }

    public function profilePost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $admin = Admin::find(Session::get('admin_id')) ;// new Admin();
                $admin->name_surname = $request['name_surname'];
                $admin->email = $request['email'];
                $admin->phone = (!empty($request['phone'])) ? $request['phone'] :"";

                $file = $request->file('avatar');
                if (!empty($file)) {

                   // return $request->file('avatar')->getClientOriginalName();

                    $path = public_path("images/admins/" . $admin->id);
                    $filename = GeneralHelper::fixName($request['name_surname']) . "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                    $file->move($path, $filename);
                    $admin->avatar = "images/admins/" . $filename;

                }


                $admin->active = (!empty($request['active']))?1:0;


                $admin->save();
                return [ 'Profil Güncellendi', 'success', route('admin-list'),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }

    public function updatePasswordPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $admin = Admin::find(Session::get('admin_id')) ;// new Admin();
                $admin->password = md5($request['pw']);

                $admin->save();
                return [ 'Şifre Güncellendi', 'success', route('admin-list'),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }


    public function login(Request $request){



        if ($request->isMethod('post')) {
            $resultArray = DB::transaction(function () use ($request) {
                $checkUser = Admin::where('email','=',$request['email'])
                    ->where('password','=',md5(trim($request['password'])))->first();
                //return response(__('admin.slider_added'), 200);
                if(!empty($checkUser['id'])){



                    if($checkUser['active']==1){

                        Session::put('admin_id',$checkUser['id']);
                        if($checkUser['sudo']){
                            Session::put('sudo',1);
                        }

                        if(!empty($request['remember_me'])){
                            Cookie::queue('remember_me', $checkUser['id'], 3600);
                        }

                        Session::put('lang',$checkUser['lang']);

                        // return  ['msg'=>__('general.login_successful'),'result'=>'success','link'=>route('admin.index'),'',''];
                        return  [ 'Giriş Başarılı', 'success', route('admin-index'),'',''];
                    }else{
                        //return  ['msg'=>__('errors.user_inactive'),'result'=>'error','link'=>route('admin.index'),'',''];
                        return  [ __('errors.user_inactive'), 'error', route('admin-index'),'',''];
                    }
                }else{
                    //return  ['msg'=>__('errors.login_error'),'result'=>'error','link'=>route('login'),'',''];
                    return  [ 'Kullanıcı Bulunamadı', 'error',route('admin-index'),'',''];
                }
            });

            return   json_encode($resultArray);
        }
        return  null; ///view('auth.login');
    }


    public function updatePassword(){
        return view('update_password');
    }



}
