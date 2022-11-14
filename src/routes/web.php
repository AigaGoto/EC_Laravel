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

Route::resource('user/product', 'User\ProductController', ['only' => ['index', 'show']]);
Route::resource('user/product/{product_id}/rate', 'User\Product\RateController', ['only' => ['store', 'update', 'destroy']]);
// Route::resource('user/product/rate', 'User\Product\RateController', ['only' => ['store', 'update', 'destroy']]);


