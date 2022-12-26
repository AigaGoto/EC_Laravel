<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Model\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $dir = 'sample';

        $latest_user_id = User::latest('user_id')->first()->user_id;
        // extension拡張子を取得する
        $extension = $data['user_icon_image']->extension();

        // ユーザーIDの一番後ろ + 1 でfile_nameを設定する
        $file_name = ($latest_user_id+1) . '.'. $extension;

        $data['user_icon_image']->storeAs('public/' . $dir, $file_name);

        return User::create([
            'user_name' => $data['user_name'],
            'user_email' => $data['user_email'],
            'user_password' => Hash::make($data['user_password']),
            'user_birthday' => $data['user_birthday'],
            'user_gender' => $data['user_gender'],
            'user_icon_image' => $file_name,
        ]);
    }
}
