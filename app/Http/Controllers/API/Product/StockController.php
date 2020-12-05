<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Combination;
use App\Models\Stock;
class StockController extends Controller
{
    protected $product;
    protected $combination;
    protected $stock;
    public function __construct(Product $product,Combination $combination,Stock $stock){
        $this->product=$product;
        $this->combination=$combination;
        $this->stock=$stock;
    }

    public function store(Request $request){
        if($request->has('product_id')){
            $str=[];
            foreach($request->input('option') as $val ){
                $str[]=strtolower(substr($val,0,1));
            }
            sort($str);
            $unique_string=implode('',$str);
            $product_id=$request->input('product_id');
            $sku=$request->input('sku');
            $price=$request->input('price');
            $quantity=$request->input('quantity');
            $discount=$request->input('discount_price');
            $combination=$this->combination->with('stock')->where('unique_string',$unique_string)
                                                          ->where('product_id',$product_id)->first();
            if(!$combination){
                $create=$this->combination->create([
                    'combination_string'=>$unique_string,
                    'sku'=>$sku,
                    'price'=>$price,
                    'unique_string'=>$unique_string,
                    'product_id'=>$product_id,
                    'discount_price'=>$discount,
                ]);
                echo $combination;
                $stock=$this->stock->where('combination_id',$create->id)->first();
                if(!$stock){
                    $stock_create=$create->stock()->create([
                        'total_stock'=>$quantity,
                        'unit_price'=>$price,
                        'total_price'=>($quantity * $price),
                    ]);
                    $create->update(['available_stock'=>$stock_create->total_stock]);
                }
                else{
                    $stock->update([
                        'total_stock'=>($stock->total_stock+$quantity),
                        'unit_price'=>$price,
                        'total_price'=>($quantity * $price),
                    ]);
                    $create->update(['available_stock'=>$stock->total_stock]);
                }
            }
            else{
                $combination->update([
                    'sku'=>$sku,
                    'price'=>$price,
                    'discount_price'=>$discount,    
                ]);
                $stock=$this->stock->where('combination_id',$combination->id)->first();
                if(!$stock){
                    $stocks_create=$combination->stock()->create([
                        'total_stock'=>$quantity,
                        'unit_price'=>$price,
                        'total_price'=>($quantity * $price),
                    ]);
                    $combination->update(['available_stock'=>$stocks_create->total_stock]);
                }
                else{
                    $stock->update([
                        'total_stock'=>($stock->total_stock+$quantity),
                        'unit_price'=>$price,
                        'total_price'=>($quantity * $price),
                    ]);
                    $combination->update(['available_stock'=>$stock->total_stock]);
                }
            }
            return response()->json('success',200);
        }
    }
}
