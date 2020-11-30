<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $table="product_variations";

    protected $fillable=['product_id','name'];

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }

    public function productVariationOptions(){
        return $this->hasMany('App\Models\ProductVariationOption','product_variation_id');
    }
}
