<?php

namespace App\Http\Controllers\Executive\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    use AuthenticatesUsers {

        logout as performLogout;

    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::EXE_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('executive.guest')->except('logout');
    }

    public function login() {
        return view('admin.executive.auth.login');
    }

    public function doLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Login attempt faild.');
        }

        $credentials = $request->only('email', 'password');
         if (Auth::guard('executive')->attempt($credentials)) {
            return redirect()->route('executive.dashboard');
         } else {
             return redirect()->back()->with('error', 'Invalid Credentials');
         }
    }

    public function logout()
    {
        Auth::guard('executive')->logout();
        return redirect()->route('executive.login');
    }
}
