<?php

namespace App\Http\Controllers\API\RBACAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $admin;
    protected $role;
    protected $permission;
    public function __construct(Admin $admin,Role $role,Permission $permission){
        $this->admin=$admin;
        $this->role=$role;
        $this->permission=$permission;
    }

    public function index(Request $request){
        if ( $request->input('showdata') ) {
            return $this->admin->with('roles')->latest()->get();
            }
            $columns = ['name', 'email','phone','status'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $query = Admin::select('name', 'email', 'phone','status')->orderBy($column);
            if ($search_input) {
                $query->where(function($query) use ($search_input) {
                $query->where('name', 'like', '%' . $search_input . '%')
                ->orWhere('email', 'like', '%' . $search_input . '%')
                ->orWhere('phone', 'like', '%' . $search_input . '%')
                ->orWhere('status', 'like', '%' . $search_input . '%')
                ->orWhere('role', 'like', '%' . $search_input . '%');
                });
                }
            $admins = $query->paginate($length);
            return ['data' => $admins];            
    }

    public function store(Request $request){
        $admin=new $this->admin;
        $admin->name=$request->input('name');
        $admin->email=$request->input('email');
        $admin->password=Hash::make($request->input('password'));
        $admin->phone=$request->input('phone');
        $admin->status=$request->input('status');
        $admin->save();
        $admin_role=$this->role->where('id',$request->input('role'))->first();
        $admin->roles()->sync($admin_role->id);
        $admin_permission=$admin_role->permissions()->pluck('id');
        $admin->permissions()->sync($admin_permission);
        return response()->json('successfully saved',200);            
    }

    public function update(Request $request){
        if($request->has('id')){
            $admin=$this->admin->where('id',$request->input('id'))->first();
            $admin->name=$request->input('name');
            $admin->email=$request->input('email');
            $admin->password=Hash::make($request->input('password'));
            $admin->phone=$request->input('phone');
            $admin->status=$request->input('status');
            $admin->update();
            $admin_role=$this->role->where('id',$request->input('role'))->first();
            $admin->roles()->sync($admin_role->id);
            $admin_permission=$admin_role->permissions()->pluck('id');
            $admin->permissions()->sync($admin_permission);
            return response()->json('successfully updated',200);            
        }
        else{
            return response()->json('error',100);
        }
    }
}
