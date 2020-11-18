<?php

namespace App\Http\Middleware\Admin;


use App\Http\Helpers\Helper;
use Closure;
use Illuminate\Support\Facades\Auth;


class AdminAuthCheckMiddleware
{


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            return $next($request);
        } else {
            return redirect(route('admin.login'));
        }
    }
}
