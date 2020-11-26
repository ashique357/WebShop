<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationOption extends Model
{
    protected $table="var_opts";

    protected $fillable=['var_id','name'];

    public function variations(){
        return $this->belongsTo('App\Models\Variation','var_id');
    }
}
