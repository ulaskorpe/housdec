<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function customerList(){
        return view('customers.list',['customers'=>Customer::all()]);
    }

    public function createCustomer(){
        return view('customers.create');
    }


    public function createCustomerPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $customer = new Customer();
                $customer->name = $request['name'];
                $customer->email = $request['email'];
                $customer->phone = (!empty($request['phone'])) ? $request['phone'] :"";
                $customer->address = (!empty($request['address'])) ? $request['address'] :"";
                $customer->save();
                return [ 'Müşteri Eklendi', 'success', route('customer-list'),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }

    public function updateCustomer($customer_id){

        return view('customers.update',['customer'=>Customer::find($customer_id)]);
    }

    public function updateCustomerPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $customer = Customer::find($request['id']);
                $customer->name = $request['name'];
                $customer->email = $request['email'];
                $customer->phone = (!empty($request['phone'])) ? $request['phone'] :"";
                $customer->address = (!empty($request['address'])) ? $request['address'] :"";

                $customer->save();
                return [ 'Müşteri Güncellendi', 'success', route('customer-list'),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }
}
