<?php

namespace App\Http\View\Composer;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use DB;

class AdminDashboard{

    public function getParentName($val){
        $parentName=Permission::where('id',$val)->select('name')->first()->toArray();
        return $parentName['name'];
    }

    public function compose(View $view){
        $menus=[];

        $user=Auth::guard('admin')->user();
        if($user == null){
            return redirect()->guest('login'); 
        }
        else{

        $menuQuery=Permission::where('status',1)->with(['admins'=>function($query){
            $query->where('admin_id',Auth::guard('admin')->user()->id)->where('status',1);
        }])->select('name','slug','parent_id','status','has_child')->orderBy('id','ASC')->get()->toArray();
        $collection=collect($menuQuery);
        $group=$collection->where('parent_id','!=',0)->groupBy('parent_id')->toArray();
        $single=$collection->where('parent_id',0)->where('has_child',0)->toArray();
    
        foreach($single as $key=>$permission){
            $menus[$key]['name']=$permission['name'];
            $menus[$key]['slug']=$permission['slug'];
            $menus[$key]['parent_id']=$permission['parent_id'];
            $menus[$key]['childs']=[];
            $menus[$key]['has_child']=$permission['has_child'];
            $menus[$key]['status']=$permission['status'];
        }

        foreach($group as $groupName=>$groupMenu){
            if(is_array($groupMenu) && count($groupMenu) > 0){
                $menus[]['childs']=[
                    'menu'=>$groupMenu,
                    'name'=>$this->getParentName($groupMenu[$groupName]['parent_id']),
                ];
            }                       
        }

        $view->with('menus',$menus);
        }
    }
}