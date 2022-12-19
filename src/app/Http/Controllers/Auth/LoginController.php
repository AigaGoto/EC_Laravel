<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Model\Log;

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

    
    public function login(Request $request)
    {
        $this->validate($request, [
            'user_email'   => 'required',
            'user_password' => 'required|min:6'
        ]);
        
        if (Auth::attempt(['user_email' => $request->user_email, 'password' => $request->user_password])) {

            //ログの作成
            Log::create([
                'log_type' => 4,
                'log_table_type' => 1,
                'log_ip_address' => $request->ip(),
                'log_user_agent' => $request->header('User-Agent'),
                'user_id' => Auth::id(),
                'log_path' => $request->path(),
            ]);

            return redirect()->intended($this->redirectTo);
        }
        return redirect('/login');
    }
    
    public function username()
    {
        return 'user_email';
    }
}
