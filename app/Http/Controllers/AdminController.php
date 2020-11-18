<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use App\Permissions\HasPermissionsTrait;

class AdminController extends Controller
{
    use HasPermissionsTrait;

    protected $admin;
    protected $role;
    public function __construct(Admin $admin,Role $role){
        $this->admin=$admin;
        $this->role=$role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user=Auth::guard('admin')->user()->id;
        // $totalQuery=$this->admin->where('id',$user)->where('status',1)->with(['roles'=>function($query){
        //     $query->where('status',1);},
        //     'permissions'=>function($query){
        //         $query->where('status',1);
        //     }
        //     ])->first();
        //     $menus=array(
        //         array()
        //     );
        //     foreach($totalQuery->permissions as $menu){
        //         $menus=array(
        //             array(
        //             'name'=>$menu->name,
        //             'slug'=>$menu->slug,
        //             'has_child'=>$menu->has_child,
        //             'parent_id'=>$menu->parent_id,
        //             'type'=>$menu->type
        //         ),
        //         );
        //     }
            
        return view('Backend.Pages.RBACAccess.Admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // // $validate = Validator::make($input, $model->validationRules($input));
        // $input = $request->all();
        // $input['password'] = Hash::make($input['password']);


        // $admin = $this->admin->create($input);
        // $admin->assignRole($request->input('roles'));


        return redirect()->route('Backend.Pages.RBACAccess.Admins.index')
                        ->with('success','Admin created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = $this->admin->find($id);
        return view('Backend.Pages.RBACAccess.Admins.edit')->with('admin',$admin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $admin = $this->admin->find($id);
        // $roles = $this->role->pluck('name','name')->all();
        // $adminRole = $admin->roles->pluck('name','name')->all();
        return view('Backend.Pages.RBACAccess.Admins.edit')->with(['admin'=>$admin,'roles'=>$roles,'adminRole'=>$adminRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }

        // $admin = $this->admin->find($id);
        // $admin->update($input);
        // DB::table('model_has_roles')->where('model_id',$id)->delete();

        // $admin->assignRole($request->input('roles'));

        return redirect()->route('admin.index')
                        ->with('success','Admin updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->admin->find($id)->delete();
        return redirect()->route('admin.index')
                        ->with('success','Admin deleted successfully');
    }
}
