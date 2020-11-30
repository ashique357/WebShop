<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $table="vars";

    protected $fillable=["name"];

    public function options(){
        return $this->hasMany('App\Models\VariationOption','var_id');
    }
}
