<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function index(){
        return view('Backend.Pages.Product.product');
    }

    public function show($id){
        $product=Product::findOrFail($id);
        return view('Backend.Pages.Product.show')->with('product',$product);
    }

    public function details($slug){
        $product=Product::where('slug',$slug)->firstOrFail();
        return view('Frontend.Pages.ProductDetails')->with('product',$product);
    }
}
