<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request){
        $request->session()->regenerate();
           $this->clearLoginAttempts($request);
           foreach ($this->guard()->user()->status as $status) {
               
                if ($status->status_name == "SuperAdmin" || $status->status_name == "Admin" || $status->status_name == "Developer" ) {
                   return redirect('system/admin');
            
                }elseif ($status->status_name == "Support") {
                   return redirect('system/support');
               }
           }
    }

}
