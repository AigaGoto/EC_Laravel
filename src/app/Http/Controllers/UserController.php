<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function purchaseHistory()
    {
        return view('user.purchaseHistory');
    }

    public function profile()
    {
        return view('user.profile');
    }
}
