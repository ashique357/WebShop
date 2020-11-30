<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Models\ProductVariationOption;
use App\Models\Product;
use App\Models\ProductGallery;
class ProductVariationController extends Controller
{
    protected $product;
    protected $prodVar;
    protected $prodVarOpt;
    
    public function __construct(Product $product, ProductVariation $prodVar,ProductVariationOption $prodVarOpt){
        $this->product=$product;
        $this->prodVar=$prodVar;
        $this->prodVarOpt=$prodVarOpt;
    }

    public function store(Request $request){
        $prodVar=new $this->prodVar;
        $prodVar->name=$request->input('name');
        $prodVar->product_id=$request->input('product_id');
        $prodVar->save();
        return response()->json('successfully saved',200);            
    }

    public function getAll(Request $request){
        if($request){
            $prodVars=$this->prodVar->where('product_id',$request->product_id)->get();
            return response()->json(['success'=>200,'prodVars'=>$prodVars]);
        }
    }

    public function getProdVar(Request $request){
        if($request){
            $prodVarOpts=$this->prodVar->with('productVariationOptions')->where('product_id',$request->product_id)->get();
            return response()->json(['success'=>200,'prodVarOpts'=>$prodVarOpts]);
        }
    }

    public function storeVarOpt(Request $request){
        $prodVarOpt=new $this->prodVarOpt;
        $prodVarOpt->name=$request->input('name');
        $prodVarOpt->product_variation_id=$request->input('prodVar_id');
        $prodVarOpt->save();
        return response()->json('successfully saved',200);            
    }

    public function soreProdImg(Request $request){
        if($request->has('option')){
            // foreach($request->option as $data){
            //     foreach($request->images as $img){
            //         $prod_img=new ProductGallery();
            //         $prod_img->product_variation_option_id=$data;
            //         $prod_img->gallery_id=$img;
            //         $prod_img->save();
            //     }
            // }
            // return response()->json(['success'=>200]);
        }
    }

}
