<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// user routing
Route::resource('user/product', 'User\ProductController', ['only' => ['index', 'show']]);
Route::resource('user/product/{product_id}/rate', 'User\Product\RateController', ['only' => ['store', 'update', 'destroy']]);
Route::resource('user/product/{product_id}/review', 'User\Product\ReviewController', ['only' => ['index', 'create', 'store']]);
Route::post('user/product/{product_id}/review/confirm', 'User\Product\ReviewController@confirm')->name('review.confirm');
Route::group(['as' => 'user.'], function() {
    Route::resource('user/review', 'User\ReviewController', ['only' => ['index', 'edit', 'update']]);
    Route::get('user/purchase-history', 'UserController@purchaseHistory')->name('purchaseHistory');
    Route::get('user/profile', 'UserController@profile')->name('profile');
    Route::put('user/profile/update', 'UserController@profileUpdate')->name('profileUpdate');
}); 

// admin routing