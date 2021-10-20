<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\GeneralHelper;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Stock;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{

    private function assignImg($product_id,$variant_id=0){
        if($variant_id>0){
            $img = ProductImage::where('product_id','=',$product_id)->where('variant_id','=',$variant_id)->orderBy('count')->first();
            if(!empty($img['id'])){
                Variant::where('id','=',$variant_id)->update(['img_id'=>$img['id']]);
            }
        }else{
            $img = ProductImage::where('product_id','=',$product_id)->orderBy('count')->first();
            if(!empty($img['id'])){
                Product::where('id','=',$product_id)->update(['img_id'=>$img['id']]);
            }
        }

    }

    private function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }

     public function productList(){
         return view('products.list',['products'=>Product::all()]);
     }

     public function createProduct(){

         $product = Product::orderBy('code','DESC')->first();
         if(empty($product['id'])){
             $code = 'DP00001';
         }else{
             $code = 0;
             $c=$product['id']+1;
             if($c<10){
                 $code = 'DP0000'.$c;

             }elseif ($c>=10 && $c<100){
                 $code = 'DP000'.$c;
             }elseif ($c>=100 && $c<1000){
                 $code = 'DP00'.$c;
             }elseif ($c>=1000 && $c<10000){
                 $code = 'DP0'.$c;
             }


         }

         return view('products.create',['products'=>Product::all(),'code'=>$code]);
     }

     public function productCodeCheck($code='00'){
         $ch = Product::where('code','=',$code)->first();

         return (!empty($ch['id'])) ? 'Bu kod kullanılmakta':'ok';

     }


    public function createProductPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $product = new Product();
                $product->product_name = $request['name'];
                $product->code = $request['code'];
                $product->description = (!empty($request['description'])) ? $request['description'] :"";
                $product->save();
                return [ 'Ürün Eklendi', 'success', route('product-update',$product['id']),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('product.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $productID]);
        }
    }

    public function updateProduct($product_id=0,$selected=0){

       // $start_at = ($start_at!=0)?  Carbon::make($start_at)->format('Y-m-d H:i:s'):Carbon::make('2021-01-01 00:00:00')->format('Y-m-d H:i:s');
        //$end_at = ($end_at!=0)? Carbon::make(date($end_at))->format('Y-m-d H:i:s') : Carbon::make(date('Y-m-d H:i:s'))->format('Y-m-d H:i:s');

                $stocks = Stock::where('product_id','=',$product_id)->orderBy('date','DESC')->get();


              //  return $stocks;

   //     $stocks = $stocks->where('created_at','>=',$start_at)->where('created_at','<=',$end_at);


        return view('products.update',
            ['product'=>Product::with('variants')->find($product_id),'product_id'=>$product_id,
                'images'=>ProductImage::with('variant')->where('product_id','=',$product_id)->orderBy('count')->get()
                ,'img_count'=>ProductImage::where('product_id','=',$product_id)->count(),'stocks'=>$stocks,'selected'=>$selected]) ;

    }


    public function updateProductPost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $product =Product::find($request['id']);
                $product->product_name = $request['name'];
                $product->description = (!empty($request['description'])) ? $request['description'] :"";
                $product->save();
                return [ 'Ürün Güncellendi', 'success', route('product-update',$product['id']),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('product.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $productID]);
        }
    }

    public function variantCreate($product_id){
        return view('products.variants.create',['product_id'=>$product_id,'product'=>Product::find($product_id)]) ;
    }

    public function variantCheck($product_id,$variant,$variant_id=0){

        if($variant_id > 0){
            $ch = Variant::where('product_id','=',$product_id)->where('variant','=',trim($variant))->where('id','<>',$variant_id)->first();
        }else{
            $ch = Variant::where('product_id','=',$product_id)->where('variant','=',trim($variant))->first();
        }


        return (!empty($ch['id'])) ? 'Ürüne ait bu varyant mevcut':'ok';
    }

    public function createVariantPost (Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $product = Product::find($request['product_id']);
                $variant = new Variant();
                $variant->product_id = $request['product_id'];
                $variant->variant = $request['variant'];
                $variant->save();
                return [ $product['product_name'].' ürününe varyant eklendi', 'success', route('product-update',[$request['product_id'],1]),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('product.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $productID]);
        }
    }

    public function updateVariantPost (Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
              //  $product = Product::find($request['product_id']);
                $variant = Variant::find($request['id']);
                $variant->product_id = $request['product_id'];
                $variant->variant = $request['variant'];
                $variant->save();
                return [  'Varyant güncellendi', 'success', route('product-update',[$request['product_id'],1]),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('product.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $productID]);
        }
    }

    public function variantUpdate($variant_id){
        return view('products.variants.update',['variant'=>Variant::with('product')->find($variant_id)]);

    }

    public function imageCreate($product_id){
        $count = ProductImage::where('product_id','=',$product_id)->count()+2 ;



     //    $count = ($count==0)?1:$count+2 ;
        return view('products.images.create',['product'=>Product::with('variants')->find($product_id),'count'=>$count]);

    }

    public function createImagePost(Request $request){

//return $request;

        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request ) {
                $path = public_path("images/products/" . $request['product_id']);
                $image       = $request->file('avatar');
                $thumb    = 'images/products/'.$request['product_id']."/TH". md5(date('YMHis')) . "." .GeneralHelper::findExtension($image->getClientOriginalName());
                if (!file_exists($path)) {
                    mkdir($path, 666, true);
                }
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(100, 100);
                $image_resize->save(public_path($thumb));



                $image = new ProductImage();
                $image->product_id = $request['product_id'];
                $image->variant_id = $request['variant_id'];

                $file = $request->file('avatar');

                  $filename =  md5(date('YmdHis')) . "." . GeneralHelper::findExtension($file->getClientOriginalName());
                 $file->move($path, $filename);
                 $image->image = "images/products/" . $request['product_id']. "/" . $filename;
                 $image->thumb = $thumb;
                 $image->count = $request['count'];
                $image->save();

                ProductImage::where('product_id','=',$request['product_id'])
                    ->where('count','>=',$request['count'])
                    ->where('id','<>',$image['id'])
                    ->increment('count');

                $this->assignImg($request['product_id'],$request['variant_id']);

                return [ 'Ürün resmi yüklendi', 'success', route('product-update',[$request['product_id'],2]),'',''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('admin.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $adminID]);
        }
    }

    public function imageDelete($img_id){


        $img = ProductImage::find($img_id);


        $this->assignImg($img['product_id'],$img['variant_id']);

        ProductImage::where('product_id','=',$img['product_id'])
            ->where('count','>=',$img['count'])
            ->where('id','<>',$img['id'])
            ->decrement('count');

       // unlink($img['thumb']);
        //unlink($img['image']);
        $img->delete();
        return "Ürün resmi silindi";
    }

    public function imageOrder($img_id,$order){
        $img= ProductImage::find($img_id);


        if($img['count']>$order){
            ProductImage::where('product_id','=',$img['product_id'])
                ->where('count','>=',$order)
                ->where('count','<=',$img['count'])
                ->where('id','<>',$img['id'])
                ->increment('count');



        }else{
            ProductImage::where('product_id','=',$img['product_id'])
                ->where('count','<=',$order)
                ->where('count','>=',$img['count'])
                ->where('id','<>',$img['id'])
                ->decrement('count');
        }
        $img->count = $order;
        $img->save();

            return 'Resim sırası güncellendi';
    }
}
