<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Admin;
use App\Models\Permission;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role=null)
    {
        $permission=$request->getRequestUri();
        $admin_id=Auth::guard('admin')->user()->id;
        $admin=Admin::find($admin_id);
        if(!$admin){
            abort(404);
        }
        else{
            $role=$admin->roles->first();
            if($role == null){
                abort(404);
            }
            else{
                $role=$admin->roles->first();
                if(!Auth::guard('admin')->user()->hasRole($role->slug)) { 
                    abort(404);
                }
                
                if($permission !== null && !Auth::guard('admin')->user()->accessUrl($role,$permission)) {  
                    abort(404);
                }   
                return $next($request);
            }
            return $next($request);
        }
        return $next($request);
    }
}
