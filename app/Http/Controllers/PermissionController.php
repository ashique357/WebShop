<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Auth;
class PermissionController extends Controller
{	

	protected $admin;
    protected $role;
    protected $permission;
    public function __construct(Admin $admin,Role $role,Permission $permission){
        $this->admin=$admin;
        $this->role=$role;
        $this->permission=$permission;
	}
	
	public function index(){
		return view('Backend.Pages.RBACAccess.Permissions.index');
	}

	// public function getMenu(){
    //     $user=Auth::guard('admin')->user()->id;
    //     $totalQuery=$this->admin->where('id',$user)->where('status',1)->with(['roles'=>function($query){
    //         $query->where('status',1);},
    //         'permissions'=>function($query){
    //             $query->where('status',1);
    //         }
    //         ])->first();
    //         $menus=array(
    //             array()
    //         );
    //         foreach($totalQuery->permissions as $menu){
    //             $menus=array(
    //                 array(
    //                 'name'=>$menu->name,
    //                 'slug'=>$menu->slug,
    //                 'has_child'=>$menu->has_child,
    //                 'parent_id'=>$menu->parent_id,
    //                 'type'=>$menu->type
    //             ),
    //             );
    //         }
    //         return view('Backend.Layouts.sidebar')->with('menus',$menus);
    // }
}
