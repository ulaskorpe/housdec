<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Variant;

class StockObserver
{
    public function created(Stock $stock)
    {


        if($stock['variant_id']>0){

            $variant = Variant::find($stock['variant_id']);

            $in = Stock::where('product_id','=',$stock['product_id'])->where('variant_id','=',$stock['variant_id'])->sum('incoming');
            $out = Stock::where('product_id','=',$stock['product_id'])->where('variant_id','=',$stock['variant_id'])->sum('outgoing');

            $variant->incoming = $in;
            $variant->outgoing = $out;
            $variant->current = $in-$out;
            $variant->save();




        }else{
            $product = Product::find($stock['product_id']);

            $in = Stock::where('product_id','=',$stock['product_id'])->sum('incoming');
            $out = Stock::where('product_id','=',$stock['product_id'])->sum('outgoing');

            $product->incoming = $in;
            $product->outgoing = $out;
            $product->current = $in-$out;
            $product->save();

        }

    }
}
