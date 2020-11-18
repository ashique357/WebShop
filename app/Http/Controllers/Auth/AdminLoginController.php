<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use const http\Client\Curl\AUTH_ANY;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    public $maxAttempts = 3;
    public $decayMinutes = 1;

    public function LoginForm(){
        return view('Backend.Auth.login');
    }
    public function DoLogin(Request $request){
        try {
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
            }
            $credentials = array(
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            );
            $remember = isset($input['remember']) ? $request->input('remember') : false;

            $limit = $this->limiter()->attempts($this->throttleKey($request));
            if ($limit <= $this->maxAttempts()){
              if (Auth::guard('admin')->attempt($credentials, $remember)) {
                return redirect(route('admin.dashboard'));
              }else{
                    $this->incrementLoginAttempts($request);
                    Session::flash('message', '<div class="text-danger">Login Failed</div>');
                    return redirect(route('admin.login'));
                }
            }else{
                $seconds = $this->limiter()->availableIn(
                    $this->throttleKey($request)
                );
                Session::flash('seconds', $seconds);
                Session::flash('message', $this->returnMaxTimeAttemptMessage($seconds));
                return redirect(route('admin.login'));
            }

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function adminLogout(){
      Auth::guard('admin')->logout();
      return redirect(route('admin.login'));
    }

    public function Dashboard(){
        return view('Backend.Pages.dashboard');
    }
    
    public function DatanbaseTest(){
        $admin = new Admin();
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('123456');
        $admin->save();

        dd($admin);
    }

    public function roleCreate(){
        $role=new Role();
        $role->name="Super Admin";
        $role->status=1;
        $role->save();
    }

    public function returnMaxTimeAttemptMessage($seconds){
        $data = '<div class="text-danger"><span style="color: red;">Too many login attempts. Please try again in after </span><span id="countdown" style="color: red;">'.$seconds.'</span><span style="color: red;"> seconds</span></div><script>
                 var timeleft = parseInt("'.$seconds.'");var downloadTimer = setInterval(function(){document.getElementById("countdown").innerHTML = timeleft;timeleft -= 1;if(timeleft <= 0){$("#login_message").html("");}}, 1000);</script>';
        return $data;
    }
}
