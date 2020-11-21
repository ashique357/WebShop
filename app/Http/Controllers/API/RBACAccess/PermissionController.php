<?php

namespace App\Http\Controllers\API\RBACAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

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

    public function index(Request $request){
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

    public function store(Request $request){
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

    public function update(Request $request){
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
}
