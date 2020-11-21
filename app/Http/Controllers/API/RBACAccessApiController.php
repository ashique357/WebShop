<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
class RBACAccessApiController extends Controller
{
    protected $admin;
    protected $role;
    protected $permission;
    public function __construct(Admin $admin,Role $role,Permission $permission){
        $this->admin=$admin;
        $this->role=$role;
        $this->permission=$permission;
    }

    public function getUsers(Request $request){
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

    public function getAllRoles(Request $request){
        if($request){
            $data=$this->role->all();
            return response()->json(['success'=>200,'data'=>$data]);
        }
    }

    public function getAllPermissionsOld(Request $request){
        if($request){
            $data=$this->permission->all();
            return response()->json(['success'=>200,'data'=>$data]);
        }
    }

    public function getAllPermissionAsMenu(Request $request){
        if($request){
            $permission=$this->permission->pluck('name','id')->all();
            return response()->json(['success'=>200,'permission'=>$permission]);
        }
    }

    public function updateUser(Request $request){
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

    public function createUser(Request $request){
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

    public function getRoles(Request $request){
        if ( $request->input('showdata') ) {
            return $this->role->with('permissions')->latest()->get();
            }
            $columns = ['name','slug', 'description','status'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $query = $this->role->select('name','slug', 'description', 'status')->orderBy($column);
            if ($search_input) {
                $query->where(function($query) use ($search_input) {
                $query->where('name', 'like', '%' . $search_input . '%')
                ->orWhere('description', 'like', '%' . $search_input . '%')
                ->orWhere('slug', 'like', '%' . $search_input . '%')
                ->orWhere('status', 'like', '%' . $search_input . '%');
                });
                }
            $roless = $query->paginate($length);
            return ['data' => $roles];            
    }

    public function updateRole(Request $request){
        if($request->has('id')){
            $role=$this->role->where('id',$request->input('id'))->first();
            $role->name=$request->input('name');
            $role->status=$request->input('status');
            $role->slug=$request->input('slug');
            $role->description=$request->input('description');
            $role->update();
            $role->permissions()->sync($request->permission);
            return response()->json('successfully updated',200);            
        }
        else{
            return response()->json('error',100);
        }
    }

    public function createRole(Request $request){
        $role=new $this->role;
        $role->name=$request->input('name');
        $role->description=$request->input('description');
        $role->status=$request->input('status');
        $role->slug=$request->input('slug');
        $role->save();
        $role->permissions()->sync($request->permission);
        // $role->admins()->where('role_id',$role->id)->get();
        // echo $role;
        return response()->json('successfully saved',200);            
    }


    public function getPermissions(Request $request){
        if ( $request->input('showdata') ) {
            return $this->permission->latest()->get();
            }
            $columns = ['name', 'slug','status','type'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $query = Permission::select('name', 'slug','status','type')->orderBy($column);
            if ($search_input) {
                $query->where(function($query) use ($search_input) {
                $query->where('name', 'like', '%' . $search_input . '%')
                ->orWhere('slug', 'like', '%' . $search_input . '%')
                ->orWhere('type', 'like', '%' . $search_input . '%')
                ->orWhere('status', 'like', '%' . $search_input . '%');
                });
                }
            $permissions = $query->paginate($length);
            return ['data' => $permissions];            
    }

    public function updatePermission(Request $request){
        $request->validate([
            'name' => 'required',
            ]);

        if($request->has('id')){
            $permission=$this->permission->where('id',$request->input('id'))->first();
            $input = $request->all();
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
            $input['slug']=str_replace(" ","-",strtolower($input['slug']));
            if($input['parent_id'] != 0){
            $parent=$this->permission->getParentId($input['parent_id']);
            $parent->has_child=1;
            $parent->slug=null;
            $parent->save(); 
            }
            $permission->update($input);

            return response()->json('successfully updated',200);            
    }
        else{
            return response()->json('error',100);
        }
    }

    public function createPermission(Request $request){
        $request->validate([
            'name' => 'required',
            ]);

            $input = $request->all();
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
            $input['slug']=str_replace(" ","-",strtolower($input['slug']));
            if($input['parent_id'] != 0){
                $parent=$this->permission->getParentId($input['parent_id']);
                $parent->has_child=1;
                $parent->slug=null;
                $parent->save(); 
            }
            $this->permission->create($input);
            
            return response()->json('successfully saved',200);            
    }

}
