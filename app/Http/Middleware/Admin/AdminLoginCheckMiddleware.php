<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminLoginCheckMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()){
            return $next($request);
        }else{
            return redirect(route('admin.dashboard'));
        }

    }
}
