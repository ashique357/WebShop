<?php

namespace App\Http\Controllers\API\RBACAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
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

    public function store(Request $request){
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

    public function update(Request $request){
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

    public function getAllRoles(Request $request){
        if($request){
            $data=$this->role->all();
            return response()->json(['success'=>200,'data'=>$data]);
        }
    }
}
