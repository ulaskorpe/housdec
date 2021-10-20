<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    use ApiTrait;
    public function providerList(){
        return view('providers.list',['providers'=>Provider::all()]);
    }

    public function createProvider(){
        return view('providers.create');
    }

    public function createProviderPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $provider = new Provider();
                $provider->name = $request['name'];
                $provider->email = $request['email'];
                $provider->phone = (!empty($request['phone'])) ? $request['phone'] :"";
                $provider->address = (!empty($request['address'])) ? $request['address'] :"";
                $provider->contact_person = (!empty($request['contact_person'])) ? $request['contact_person'] :"";

                $file = $request->file('avatar');
                if (!empty($file)) {

                    // return $request->file('avatar')->getClientOriginalName();

                    $path = public_path("images/providers/");
                    $filename = GeneralHelper::fixName($request['name']) . "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                    $file->move($path, $filename);
                    $provider->logo = "images/providers/". $filename;

                }


                $provider->save();
                return [ 'Tedarikçi Eklendi', 'success', route('provider-list'),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }

    public function updateProvider($provider_id){

        return view('providers.update',['provider'=>Provider::find($provider_id)]);
    }

    public function updateProviderPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $provider = Provider::find($request['id']);
                $provider->name = $request['name'];
                $provider->email = $request['email'];
                $provider->phone = (!empty($request['phone'])) ? $request['phone'] :"";
                $provider->address = (!empty($request['address'])) ? $request['address'] :"";
                $provider->contact_person = (!empty($request['contact_person'])) ? $request['contact_person'] :"";

                $file = $request->file('avatar');
                if (!empty($file)) {

                    // return $request->file('avatar')->getClientOriginalName();

                    $path = public_path("images/providers/");
                    $filename = GeneralHelper::fixName($request['name']) . "_" . date('YmdHis') . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                    $file->move($path, $filename);
                    $provider->logo = "images/providers/". $filename;

                }


                $provider->save();
                return [ 'Tedarikçi Güncellendi', 'success', route('provider-list'),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }
}
