<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_name = $request->input('user_name');

        $query = User::query();

        // ユーザー名が入力されているなら、検索する
        if (!empty($user_name)) {
            $query->where('user_name', 'LIKE', "%{$user_name}%");
        }

        $users = $query->paginate(5);

        // レビューに基づいたユーザーと商品のデータを紐付ける
        foreach ($users as $key => $value) {
            $users[$key]['review_count'] = $users[$key]->reviews->count();
        }

        return view('admin.user.index', compact('users', 'user_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $root_path = 'public/sample/';

        $newImage = $request->file('user_icon_image');
        
        $file_name = $user->user_icon_image;
        
        if(isset($newImage)) {
            \Storage::delete($root_path . $file_name);
            $path = $newImage->storeAs($root_path, $file_name);
        }

        $user->update([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_birthday' => $request->user_birthday,
            'user_gender' => $request->user_gender,
            'user_icon_image' => $file_name,
        ]);

        return redirect()->back();
    }
}
