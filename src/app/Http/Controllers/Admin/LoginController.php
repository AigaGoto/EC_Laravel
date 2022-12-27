<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CreateLogService;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/home';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/admin/login');
    }

    public function login(Request $request, CreateLogService $createLogService)
    {
        $this->validate($request, [
            'admin_email'   => 'required',
            'admin_password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['admin_email' => $request->admin_email, 'password' => $request->admin_password])) {

            DB::beginTransaction();
            try {
                // ログの作成
                $createLogService->createLog(\Consts::LOG_LOGIN, \Consts::TABLE_ADMIN, Auth::guard('admin')->id(), $request);

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
        return 'admin_email';
    }
}
