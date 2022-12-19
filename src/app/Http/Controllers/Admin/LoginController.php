<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\Log;

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

    public function login(Request $request)
    {
        $this->validate($request, [
            'admin_email'   => 'required',
            'admin_password' => 'required|min:6'
        ]);
        
        if (Auth::guard('admin')->attempt(['admin_email' => $request->admin_email, 'password' => $request->admin_password])) {

            // ログの作成
            Log::create([
                'log_type' => 4,
                'log_table_type' => 6,
                'log_ip_address' => $request->ip(),
                'log_user_agent' => $request->header('User-Agent'),
                'user_id' => Auth::guard('admin')->id(),
                'log_path' => $request->path(),
            ]);
            
            return redirect()->intended($this->redirectTo);
        }

        
        return redirect('/admin/login');
    }
    
    public function username()
    {
        return 'admin_email';
    }
}
