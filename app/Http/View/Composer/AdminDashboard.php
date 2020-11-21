<?php

namespace App\Http\View\Composer;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use DB;

class AdminDashboard{

    public function compose(View $view){
        $user=Auth::guard('admin')->user();
        if($user == null){
            return redirect()->guest('login'); 
        }
        else{

        $totalQuery=Admin::where('id',$user->id)->where('status',1)->with(['roles'=>function($query){
            $query->where('status',1);},
            'permissions'=>function($query){
                //  $query->where('parent_id',0);
            }
            ])->first();
            $menus=[];
            $i=0;

            if($totalQuery != null){
                foreach($totalQuery->permissions as $menu){
                    $menus[] = [
                        'id'=>++$i,
                        'name'=>$menu->name,
                        'slug'=>$menu->slug,
                        'parent_id'=>$menu->parent_id,
                        'has_child'=>$menu->has_child,
                        'relations'=>$menu->childs,
                        'parents'=>$menu->parents,
                    ];   
                }

            }
            else{
                abort(403, 'Unauthorized action');
            }
            
        $view->with('menus',$menus);
        }
    }
}