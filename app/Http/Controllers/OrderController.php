<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Stock;
use App\Models\Variant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
{


     public function createOrder(){
         return view('order.create',['providers'=>Provider::all(),'customers'=>Customer::all(),'products'=>Product::all()]);
     }

     public function updateOrder($order_id){

         return view('order.update',['providers'=>Provider::all(),'customers'=>Customer::all(),'products'=>Product::all(),
             'order'=>Order::with('order_products')->find($order_id)]);
     }

     public function getVariants($product_id,$selected=0){
         $variants = Variant::where('product_id','=',$product_id)->orderBy('variant')->get();

         if(count($variants)>0){

             if($selected==0){
                 $txt=  "<option value=''>Seçiniz</option>";

         foreach ($variants as $variant){
            $txt.="<option value='".$variant['id']."'>".$variant['variant']."</option>";
         }
             }else{
                 $txt=  "";
                 foreach ($variants as $variant){
                     if($variant['id']==$selected){
                         $txt.="<option value='".$variant['id']."' selected>".$variant['variant']."</option>";
                     }else{
                         $txt.="<option value='".$variant['id']."'>".$variant['variant']."</option>";
                     }

                 }
             }
         }else{
             $txt="no";
         }
         return $txt;

     }

     public function additionalProduct($count){
         return view('order.additional',['count'=>$count+1,'products'=>Product::all()]);
     }

     public function checkProducts($products){
       //  echo $products." : ";
         $list = explode('@',$products);
         $txt="";
         $product_array=[];
         foreach ($list as $item){
             if(!empty($item)){
                 $product_array[]=$item;
             }
         }
        $item_array=[];
         $id_array=[];
         $count = 0;
         foreach ($product_array as $item){

             $dz = explode('x',$item);
             $item_array[$count]['product']=Product::find($dz[0]);

             $item_array[$count]['variant']=Variant::find($dz[1]);


             $item_array[$count]['qty']=$dz[2];

            $count++;
         }


        // echo $count."----";
         return $item_array;
     }


     private function stockCalculate($product_list,$order_id){
         $order = Order::with('order_products')->find($order_id);
         OrderProduct::where('order_id','=',$order_id)->delete();
         Stock::where('order_id','=',$order_id)->delete();
         $list = explode('@',$product_list);
         $txt="";
         $product_array=[];
         foreach ($list as $item){
             if(!empty($item)){
                 $product_array[]=$item;
             }
         }
         $item_array=[];
         $count = 0;
         foreach ($product_array as $item){

             $dz = explode('x',$item);
             $item_array[$count]['product']=Product::find($dz[0]);

             $item_array[$count]['variant']=Variant::find($dz[1]);


             $item_array[$count]['qty']=$dz[2];


             $order_product= new OrderProduct();
             $order_product->order_id = $order_id;
             $order_product->product_id = $dz[0];
             $order_product->variant_id = ($dz[1]>0)?$dz[1]:0;
             $order_product->quantity = $dz[2];
             $order_product->save();

             /////stok//////
             if($order['status']==2){////tamamlanmış
                $stock = new  Stock();
                $stock->product_id = $dz[0];
                $stock->variant_id =  ($dz[1]>0)?$dz[1]:0;
                $stock->incoming = 0;
                $stock->outgoing = $dz[2];
                $stock->order_id = $order_id;
                $stock->save();


             }///status 2
             $count++;
         }





     }

     public function createOrderPost(Request $request){
         if ($request->isMethod('post')) {

        //     return $request['invoice_date'];

             $messages = [];
             $rules = [

             ];
             $this->validate($request, $rules, $messages);
             $resultArray = DB::transaction(function () use ($request) {


                 $order= new Order();
                 $order->provider_id = $request['provider_id'];
                 $order->status = $request['status'];
                 $order->order_date = $request['order_date'];
                 $order->order_id = $request['order_id'];

                 if($request['status']==2){
                     $order->invoice_date = $request['invoice_date'];
                     $order->invoice_id = $request['invoice_id'];
                 }

                 $order->customer_name = $request['customer_name'];
                 $order->customer_phone = (!empty($request['customer_phone']))? $request['customer_phone']:'';
                 $order->customer_email = (!empty($request['customer_email']))? $request['customer_email']:'';
                 $order->amount =   $request['amount'] ;
                 $order->product_list = $request['product_list'];
                 $order->save();

                 $customer = Customer::where('name','=',$request['customer_name'])->first();
                 if(empty($customer['id'])){
                     $customer = new Customer();
                     $customer->name = $request['customer_name'];
                     $customer->phone =(!empty($request['customer_phone']))? $request['customer_phone']:'';
                     $customer->email =(!empty($request['customer_email']))? $request['customer_email']:'';
                     $customer->save();
                 }else{
                     $customer->phone =(!empty($request['customer_phone']))? $request['customer_phone']:'';
                     $customer->email =(!empty($request['customer_email']))? $request['customer_email']:'';
                     $customer->save();
                 }

               //  return $order;

                $this->stockCalculate($request['product_list'],$order['id']);
                 return [  'yeni siparişi eklendi', 'success', route('admin-index'), '', ''];
             });
             return json_encode($resultArray);
             // return json_encode([  'profiliniz güncellendi','success', route('product.index'),'','']);
             // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $productID]);
         }
     }

     public function updateOrderPost(Request $request){
         if ($request->isMethod('post')) {

        //     return $request['invoice_date'];

             $messages = [];
             $rules = [

             ];
             $this->validate($request, $rules, $messages);
             $resultArray = DB::transaction(function () use ($request) {


                 $order= Order::find($request['id']);
                 $order->provider_id = $request['provider_id'];
                 $order->status = $request['status'];
                 $order->order_date = $request['order_date'];
                 $order->order_id = $request['order_id'];


                 if($request['status']==2){
                     $order->invoice_date = $request['invoice_date'];
                     $order->invoice_id = $request['invoice_id'];
                 }

                 $order->customer_name = $request['customer_name'];
                 $order->customer_phone = (!empty($request['customer_phone']))? $request['customer_phone']:'';
                 $order->customer_email = (!empty($request['customer_email']))? $request['customer_email']:'';
                 $order->amount =   $request['amount'] ;
                 $order->product_list = $request['product_list'];
                 $order->save();

                // Stock::where('order_id','=',$order['id'])->delete();

                 $customer = Customer::where('name','=',$request['customer_name'])->first();
                 if(empty($customer['id'])){
                     $customer = new Customer();
                     $customer->name = $request['customer_name'];
                     $customer->phone =(!empty($request['customer_phone']))? $request['customer_phone']:'';
                     $customer->email =(!empty($request['customer_email']))? $request['customer_email']:'';
                     $customer->save();
                 }else{
                     $customer->phone =(!empty($request['customer_phone']))? $request['customer_phone']:'';
                     $customer->email =(!empty($request['customer_email']))? $request['customer_email']:'';
                     $customer->save();
                 }

               //  return $order;

                $this->stockCalculate($request['product_list'],$order['id']);
                 return [  'Sipariş Güncellendi', 'success', route('admin-index'), '', ''];
             });
             return json_encode($resultArray);
             // return json_encode([  'profiliniz güncellendi','success', route('product.index'),'','']);
             // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $productID]);
         }
     }

     public function deleteOrder($order_id){
         OrderProduct::where('order_id','=',$order_id)->delete();
         Stock::where('order_id','=',$order_id)->delete();
         Order::where('id','=',$order_id)->delete();
         return "sipariş silindi";
     }
}
/** for($i=0;$i<3;$i++){
switch ($i) {
case 0:

$product = Product::find($dz[0]);
break;
case 1:
if($dz[1]>0){
$variant = Variant::find($dz[1]);
}else{
$variant = null;
}

break;
case 2:

$gty = $dz[2];
break;
}
}**/