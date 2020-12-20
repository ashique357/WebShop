<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="products";

    protected $fillable=['name','slug','category_id','category_name','previewImage','price','discount_price','is_featured','is_top_seller',
    'summary','status','description','is_new','discount_rate'];

    // public function varionOptions(){
    //     return $this->belongsToMany('App\Models\ProductVariationOption','product_id');
    // }

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function combinations(){
        return $this->hasMany('App\Models\Combination','product_id','id');
    }

    public function productVariations(){
        return $this->hasMany('App\Models\ProductVariation','product_id','id');
    }
}
