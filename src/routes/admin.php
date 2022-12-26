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

// admin routing
Route::group(['prefix'=>'admin','as' => 'admin.'], function() {
    Route::get('login', 'Admin\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Admin\LoginController@login');
    Route::post('logout', 'Admin\LoginController@logout')->name('logout');

    Route::get('home', 'Admin\HomeController@index')->name('home');

    Route::resource('review', 'Admin\ReviewController', ['only' => ['index', 'show', 'destroy']]);

    Route::resource('user', 'Admin\UserController', ['only' => ['index', 'edit', 'update']]);

    Route::resource('product', 'Admin\ProductController', ['only' => ['index', 'edit', 'update', 'destroy']]);

    Route::resource('admin', 'Admin\AdminController', ['only' => ['index', 'create', 'store']]);

    Route::get('system-info', 'Admin\SystemInfoController@index')->name('systemInfo.index');
    Route::put('system-info/update', 'Admin\SystemInfoController@update')->name('systemInfo.update');

    Route::get('profile', 'Admin\ProfileController@index')->name('profile.index');
    Route::put('profile/update', 'Admin\ProfileController@update')->name('profile.update');

    // Route::resource('profile', 'Admin\ProfileController', ['only' => ['index', 'update']]);
    Route::get('log', 'Admin\LogController@index')->name('log');
});