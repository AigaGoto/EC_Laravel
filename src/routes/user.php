<?php

// user routing
Route::group(['prefix'=>'user', 'as' => 'user.'], function() {
    Auth::routes();
    Route::resource('product', 'User\ProductController', ['only' => ['index', 'show']]);
    Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
        Route::resource('{product_id}/rate', 'User\Product\RateController', ['only' => ['store', 'update', 'destroy']]);
        Route::resource('{product_id}/review', 'User\Product\ReviewController', ['only' => ['index', 'create', 'store']]);
        Route::post('{product_id}/review/confirm', 'User\Product\ReviewController@confirm')->name('review.confirm');
    });
    Route::resource('review', 'User\ReviewController', ['only' => ['index', 'edit', 'update']]);
    Route::post('review/{review_id}/confirm', 'User\ReviewController@confirm')->name('review.confirm');
    Route::get('purchase-history', 'UserController@purchaseHistory')->name('purchaseHistory');
    Route::get('profile', 'UserController@profile')->name('profile');
    Route::put('profile/update', 'UserController@profileUpdate')->name('profileUpdate');
});
