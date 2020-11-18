<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name','slug','parent_id','status','has_child'];
    public function childs() {
        return $this->hasMany('App\Models\Category','parent_id','id') ;
     }
  
       public function getAllCategories(){
           $data = Category::pluck('name','id')->all();
       }
  
       public function getParentId($value){
        $getId=Category::where('id','=',$value)->first();
        return $getId;
    }
}
