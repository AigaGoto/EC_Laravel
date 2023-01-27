<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Model\User;
use App\Model\Log;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => ['required', 'string', 'max:20'],
            'user_email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'user_password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_birthday' => ['required', 'date'],
            'user_gender' => ['required', 'integer'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $newImage = base64_decode(explode(",", $data['user_icon_image'])[1]);
        if (!empty($newImage)) {
            $dir = 'sample';

            $latest_user_id = User::latest('user_id')->first()->user_id;

            $root_path = '/app/public/sample/';

            // ユーザーIDの一番後ろ + 1 でfile_nameを設定する
            $file_name = ($latest_user_id+1) . '.'. 'jpg';

            $save_file_path =storage_path() . $root_path . $file_name;
            \file_put_contents($save_file_path, $newImage);
        } else {
            $file_name = '';
        }


        DB::beginTransaction();
        try {
            $user = User::create([
                'user_name' => $data['user_name'],
                'user_email' => $data['user_email'],
                'user_password' => Hash::make($data['user_password']),
                'user_birthday' => $data['user_birthday'],
                'user_gender' => $data['user_gender'],
                'user_icon_image' => $file_name,
            ]);

            $log = Log::create([
                'log_type' => \Consts::LOG_REGISTER,
                'log_table_type' => \Consts::TABLE_USER,
                'log_ip_address' => $_SERVER["REMOTE_ADDR"],
                'log_user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'user_id' => $user->user_id,
                'log_path' => $_SERVER['REQUEST_URI'],
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return $user;
    }
}
