<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        $reviews = $user->reviews()->paginate(5);
        foreach ($reviews as $key=>$review) {
            $diff_hours = now()->diffInHours($review->created_at);
            if($diff_hours <= 12) {
                $True = True;
                $reviews[$key]['canEdit']= $True;
            }
        }
        return view('user.review.index', compact('reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.review.edit');
    }

    public function update()
    {

    }
}
