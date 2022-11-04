<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('user_email', 'user_password');

    //     if (Auth::attempt($credentials)) {
    //         // 認証に成功した
    //         return redirect()->intended('home');
    //     }
    // }

    public function login(Request $request)
    {
        $this->validate($request, [
            'user_email'   => 'required',
            'user_password' => 'required|min:6'
        ]);

        if (Auth::attempt(['user_email' => $request->user_email, 'password' => $request->user_password])) {

            // return redirect()->intended('/home');
            return redirect('/home');
        }
        // return back()->withInput($request->only('name', 'remember'));
    }

}
