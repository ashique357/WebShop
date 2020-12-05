<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table="stocks";

    protected $fillable=['total_stock','unit_price','total_price','combination_id'];

    protected $casts = [
        'unit_price'  =>  'float',
        'total_stock'=>  'integer',
        'total_price'=>'float',
    ];

    public function combination(){
        return $this->belongsTo('App\Models\Combination'); 
    }
}
