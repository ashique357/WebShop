<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

   protected $fillable=[
      'name','slug','type','parent_id','has_child','status'
   ];
   
    public function roles() {

        return $this->belongsToMany(Role::class,'roles_permissions');
            
     }
     
     public function admins() {
     
        return $this->belongsToMany(Admin::class,'admins_permissions');
            
     }

     public function childs() {
      return $this->hasMany('App\Models\Permission','parent_id','id') ;
   }

     public function getAllPermissions(){
         $data = Permission::pluck('name','id')->all();
     }

     public function getParentId($value){
      $getId=Permission::where('id','=',$value)->first();
      return $getId;
  }
}
