<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CreateLogService;

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


    public function login(Request $request, CreateLogService $createLogService)
    {
        $this->validate($request, [
            'user_email'   => 'required',
            'user_password' => 'required|min:6'
        ]);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (Auth::attempt(['user_email' => $request->user_email, 'password' => $request->user_password])) {
            DB::beginTransaction();
            try {
                //ログの作成
                $createLogService->createLog(\Consts::LOG_LOGIN, \Consts::TABLE_USER, Auth::id(), $request);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

            return redirect()->intended($this->redirectTo);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function username()
    {
        return 'user_email';
    }
}
