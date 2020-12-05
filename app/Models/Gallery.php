<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table="galleries";

    // public function productVariationOptions(){
    //     return $this->belongsToMany('App\Models\ProductVariationOption','product_variation_option_id')->withPivot('product_gallery');
    // }

    public function productVariationOptions(){
        return $this->belongsToMany(ProductVariationOption::class,'product_galleries');
    }
}
