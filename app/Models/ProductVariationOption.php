<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationOption extends Model
{
    protected $table="product_variation_options";

    protected $fillable=['product_variation_id','name'];

    public function productVariation(){
        return $this->belongsTo('App\Models\ProductVariation','product_variation_id');
    }

    public function galleries(){
        return $this->belongsToMany(Gallery::class,'product_galleries');
    }
}
