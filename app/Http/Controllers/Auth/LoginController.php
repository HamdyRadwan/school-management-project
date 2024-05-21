<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\AuthTrait;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    use AuthTrait;
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

    // use AuthenticatesUsers;
    // protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }  
    
    public function loginForm($type){
        // return $type;
        return view('auth.login',compact('type'));
    }

    public function login(Request $request){

        // return $request;
        if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->redirect($request);
        }else{
            return redirect()->back()->with('message', 'there is error in name or pasword');
        }
    }

    public function logout(Request $request,$type)
    {
        // return $type;
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
