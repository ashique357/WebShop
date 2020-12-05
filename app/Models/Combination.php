<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combination extends Model
{
    protected $table="combinations";

    protected $fillable=['combination_string','sku','price','unique_string','available_stock','product_id','discount_price'];

    protected $casts = [
        'price'  =>  'float',
        'discount_price'  =>  'float',
        'available_stock'=>  'integer',
    ];

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }

    public function stocks(){
        return $this->hasMany('App\Models\Stock','combination_id');
    }

}
