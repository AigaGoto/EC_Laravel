<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Order;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function purchaseHistory()
    {
        $orders = Order::with('product')->where('user_id', Auth::id())->paginate(5);
        // $orders = Order::with('product')->where('user_id', Auth::id())->get();
        // dd($orders[0]->product->product_name);


        return view('user.purchaseHistory', compact('orders'));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function profileUpdate(Request $request)
    {
        // $dir = 'sample';

        // $file_name = $request->user_icon_image->getClientOriginalName();

        // $request->user_icon_image->storeAs('public/' . $dir, $file_name);

        $root_path = 'public/sample/';

        $newImage = $request->file('user_icon_image');
        
        $file_name = Auth::user()->user_icon_image;
        
        if(isset($newImage)) {
            \Storage::delete($root_path . $file_name);
            $path = $newImage->storeAs($root_path, $file_name);
        }

        Auth::user()->update([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_birthday' => $request->user_birthday,
            'user_gender' => $request->user_gender,
            'user_icon_image' => $file_name,
        ]);

        return redirect()->back();
    }
}
