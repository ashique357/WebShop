<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Models\ProductVariationOption;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Gallery;

class ProductVariationController extends Controller
{
    protected $product;
    protected $prodVar;
    protected $prodVarOpt;
    protected $gallery;
    public function __construct(Gallery $gallery,Product $product, ProductVariation $prodVar,ProductVariationOption $prodVarOpt){
        $this->product=$product;
        $this->prodVar=$prodVar;
        $this->prodVarOpt=$prodVarOpt;
        $this->gallery=$gallery;
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
            foreach($request->input('images') as $image){
                $prod_image=new ProductGallery();
                $prod_image->product_variation_option_id=$request->input('option');
                $prod_image->gallery_id=$image;
                if($request->input('preview_image') == $image){
                    $prod_image->isFeatured=1;
                    $getImage=$this->gallery->where('id',$request->input('preview_image'))->first();
                    $product=$this->product->where('id',$request->input('product_id'))->update(['preview_image'=>$getImage->large]);
                }
                else{
                    $prod_image->isFeatured=0;
                }
                $prod_image->save();
            }
            return response()->json('success',200);
        }
    }

}
