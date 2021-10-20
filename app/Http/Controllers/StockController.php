<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    use ApiTrait;

    public function stockList($product_id = 0, $variant_id = 0, $start_at = 0, $end_at = 0)
    {


        $start_at = ($start_at != 0) ? Carbon::parse($start_at)->format('Y-m-d') : Carbon::parse('2021-01-01')->format('Y-m-d');
        $end_at = ($end_at != 0) ? Carbon::parse(date($end_at))->format('Y-m-d') : Carbon::parse('2121-01-01')->format('Y-m-d');


        if ($product_id == 0) {
            $stocks = Stock::with('product.img', 'variant.img', 'order')
                ->where('id', '>', 0)
                ->where('date', '>=', $start_at)->where('date', '<=', $end_at)->get();
        } else {
            if ($variant_id > 0) {
                $stocks = Stock::with('product.img', 'variant.img', 'order')
                    ->where('product_id', '=', $product_id)
                    ->where('variant_id', '=', $variant_id)->where('date', '>=', $start_at)
                    ->where('date', '<=', $end_at)->get();
            } else {
                $stocks = Stock::with('product.img', 'variant.img', 'order')
                    ->where('product_id', '=', $product_id)
                    ->where('date', '>=', $start_at)->where('date', '<=', $end_at)->get();
            }

        }

//return $stocks;
        //$stocks = $stocks->where('created_at','>=',$start_at)->where('created_at','<=',$end_at)->get();

        return view('stocks.list', ['stocks' => $stocks,'product_id'=>$product_id,'variant_id'=>$variant_id]);
    }

    public function createStock($product_id = 0)
    {


        $product = ($product_id > 0) ? Product::find($product_id) : null;
        $variants = ($product_id > 0) ? Variant::where('product_id', '=', $product_id)->get() : null;
        $variants_count = ($product_id > 0) ? Variant::where('product_id', '=', $product_id)->count() : 0;


        return view('stocks.create', ['product' => $product, 'variants' => $variants, 'product_id' => $product_id, 'variants_count' => $variants_count,
            'products' => Product::select('id', 'product_name')->orderBy('product_name')->get()]);
    }

    public function createStockPost(Request $request)
    {
        if ($request->isMethod('post')) {
            $messages = [];
            $rules = [

            ];
            $this->validate($request, $rules, $messages);
            $resultArray = DB::transaction(function () use ($request) {

                ///   return Carbon::parse($request['stock_date'])->format('Y-m-d');

                $product = Product::find($request['product_id']);
                $stock = new Stock();
                $stock->product_id = $request['product_id'];
                $stock->variant_id = (!empty($request['variant_id'])) ? $request['variant_id'] : 0;
                $stock->date = $request['stock_date'];//Carbon::parse($request['stock_date'])->format('Y-m-d');
                if ($request['going'] == 'in') {
                    $stock->incoming = $request['qty'];
                    $stock->outgoing = 0;
                } else {
                    $stock->incoming = 0;
                    $stock->outgoing = $request['qty'];
                }
                $stock->save();


                return [$product['product_name'] . ' ürününe stok hareketi eklendi', 'success', route('product-update', [$request['product_id'], 3]), '', ''];
            });
            return json_encode($resultArray);
            // return json_encode([  'profiliniz güncellendi','success', route('product.index'),'','']);
            // return json_encode(['msg' => 'profiliniz güncellendi', 'id' => $productID]);
        }
    }


    public function deleteStock($stock_id)
    {
        Stock::where('id', '=', $stock_id)->delete();
        return "Stok hareketi silindi";

    }

    public function countStock($product_id, $variant_id = 0)
    {
        $in = Stock::where('product_id', '=', $product_id)->where('variant_id', '=', $variant_id)->sum('incoming');
        $out = Stock::where('product_id', '=', $product_id)->where('variant_id', '=', $variant_id)->sum('outgoing');
        return $in - $out;


    }

}
