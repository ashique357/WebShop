<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function variations(){
        return view('Backend.Pages.Product.variation');
    }

    public function variationOption(){
        return view('Backend.Pages.Product.variation_option');
    }

    public function gallery(){
        return view('Backend.Pages.Product.gallery');
    }

    public function productVariants(){
        return view('Backend.Pages.Product.product_variants');
    }
}
