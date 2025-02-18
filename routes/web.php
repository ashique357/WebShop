<?php

Route::middleware('AdminLoginCheck')->group(function () {
    Route::get('/admin/login', 'Auth\AdminLoginController@LoginForm')->name('admin.login');
    Route::post('/admin/login', 'Auth\AdminLoginController@DoLogin')->name('admin.login.submit');
});

Route::prefix('admin')->middleware('AdminAuthCheck')->group(function () {
    Route::get('/dashboard', 'Auth\AdminLoginController@Dashboard')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
});

Route::prefix('admin')->middleware(['AdminAuthCheck'])->group(function () {

    Route::resource('/user','AdminController');
    Route::resource('/role','RoleController');
    Route::get('/permission','PermissionController@index')->name('permission.index');
    Route::get('/category','CategoryController@index')->name('category.index');

    Route::get('/product','ProductController@index')->name('admin.product.index');
    Route::get('/product/{id}','ProductController@show')->name('admin.product.show');
    Route::get('/gallery','VariationController@gallery')->name('gallery.index');
    Route::get('/variation','VariationController@variations')->name('variation');
    Route::get('/variation/option','VariationController@variationOption')->name('variation.option');

});


Route::get('/product/{slug}','ProductController@details')->name('product.details');


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    return 'DONE'; 
});

Route::get('/create-dummy-admin', 'Auth\AdminLoginController@DatanbaseTest');

Route::get('/admin/{any}', function () {
    return view('Backend.index');
})->where('any', '.*')->name('admin.home')->middleware('AdminAuthCheck');


Route::get('/{any}', function (){
    return view('Frontend.index');
})->where('any', '^(?!admin_api).*$');
