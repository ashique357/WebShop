<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="products";

    protected $fillable=['name','slug','category_id','category_name','previewImage'];

    public function varionOptions(){
        return $this->belongsToMany('App\Models\VariationOption');
    }

    public function categories(){
        return $this->belongsTo('App\Models\Category');
    }

    public function combination(){
        return $this->hasMany('App\Models\Combination');
    }

    public function productVariation(){
        return $this->hasMany('App\Models\ProductVariation','product_id');
    }
}
