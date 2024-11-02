<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        $this->middleware('employee.guest')->except('logout');
    }

    // public function login() {
    //     return view('admin.employee.auth.login');
    // }

    public function showLoginForm()
    {
        return view('admin.employee.auth.login');
    }

    // public function doLogin(Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->with('error', 'Login attempt faild.');
    //     }

    //     $credentials = $request->only('email', 'password');
    //      if (Auth::guard('employee')->attempt(array_merge($credentials, ['status' => 1]),)) {
    //         return redirect()->route('employee.dashboard');
    //      } else {
    //          return redirect()->back()->with('error', 'Invalid Credentials');
    //      }
    // }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            return redirect()->intended(route('employee.dashboard'));
            // return redirect()->route('employee.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    protected function validateLogin(Request $request)
    {
        // Check if the input is an email
        if (filter_var($request->input('username'), FILTER_VALIDATE_EMAIL)) {
            // Validate as email
            $request->validate([
                'username' => 'required|email|exists:employees,email', // Check if email exists in users table
                'password' => 'required|string',
            ]);
        } else {
            // Validate as phone
            $request->validate([
                'username' => 'required|string|regex:/^[0-9]{10}$/|exists:employees,phone', // Regex for 10-digit phone numbers
                'password' => 'required|string',
            ]);
        }
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            array_merge($this->credentials($request), ['status' => 1]),
            $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        // return $request->only('email', 'password');
        $loginField = $this->loginField($request);

        return [
            $loginField => $request->input('username'),
            'password' => $request->input('password'),
        ];
    }

    protected function loginField(Request $request)
    {
        $username = $request->input('username');

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        return 'phone';
    }

    protected function guard()
    {
        return Auth::guard('employee');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        // $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }

    // public function logout()
    // {
    //     Auth::guard('employee')->logout();
    //     return redirect()->route('employee.login');
    // }
}
