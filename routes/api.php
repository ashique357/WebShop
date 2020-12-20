<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/user/index','API\RBACAccess\AdminController@index')->name('admin.user.index');
    Route::post('/user/store','API\RBACAccess\AdminController@store')->name('admin.user.store');
    Route::post('/user/update','API\RBACAccess\AdminController@update')->name('admin.user.update');

    Route::get('/role/index','API\RBACAccess\RoleController@index')->name('admin.role.index');
    Route::post('/role/store','API\RBACAccess\RoleController@store')->name('admin.role.store');
    Route::post('/role/update','API\RBACAccess\RoleController@update')->name('admin.role.update');

    Route::get('/permission/index','API\RBACAccess\PermissionController@index')->name('admin.permission.index');
    Route::post('/permission/store','API\RBACAccess\PermissionController@store')->name('admin.permission.store');
    Route::post('/permission/update','API\RBACAccess\PermissionController@update')->name('admin.permission.update');

    Route::post('/get-all-roles','API\RBACAccess\RoleController@getAllRoles')->name('admin.get-all-roles');
    Route::post('/get-all-permissions-old','API\RBACAccess\PermissionController@getAllPermissionsOld')->name('admin.get-all-permissions-old');
    Route::post('/get-all-permissions-menu','API\RBACAccess\PermissionController@getAllPermissionAsMenu')->name('admin.get-all-permissions');
   
    Route::get('/category/index','API\CategoryController@index')->name('admin.category.index');
    Route::post('/category/store','API\CategoryController@store')->name('admin.category.store');
    Route::post('/category/update','API\CategoryController@update')->name('admin.category.update');

    Route::post('/get-all-categories','API\CategoryController@getAllCategories')->name('admin.get-all-categories');

    Route::get('/variation/index','API\Product\VariationController@index')->name('admin.variation.index');
    Route::post('/variation/store','API\Product\VariationController@store')->name('admin.variation.store');
    Route::post('/variation/update','API\Product\VariationController@update')->name('admin.variation.update');
    Route::post('/get-all-variations','API\Product\VariationController@getAllVariations')->name('admin.get-all-variations');

    Route::get('/variation/option/index','API\Product\VariationOptionController@index')->name('admin.variation.option.index');
    Route::post('/variation/option/store','API\Product\VariationOptionController@store')->name('admin.variation.option.store');
    Route::post('/variation/option/update','API\Product\VariationOptionController@update')->name('admin.variation.option.update');
    Route::post('/get-all-variation-options','API\Product\VariationOptionController@getAllVariationOption')->name('admin.get-all-variations-option');
 
    Route::get('/get-var','API\Product\VariationOptionController@getVar')->name('admin.get-var');

    Route::post('/gallery/index','API\GalleryController@index')->name('admin.gallery.index');
    Route::post('/gallery/store','API\GalleryController@store')->name('admin.gallery.store');
    // Route::post('/variation/option/update','API\Product\VariationOptionController@update')->name('admin.variation.option.update');
    Route::post('/gallery/all','API\GalleryController@getAll')->name('admin.gallery.all');

    Route::get('/product/index','API\Product\ProductController@index')->name('admin.product.index');
    Route::post('/product/store','API\Product\ProductController@store')->name('admin.product.store');
    Route::post('/product/update','API\Product\ProductController@update')->name('admin.product.update');

    Route::post('/stores','API\Product\StockController@store')->name('admin.product.stores.store');

    Route::post('/product/variation/store','API\Product\ProductVariationController@store')->name('admin.product.variation.store');
    Route::post('/product/variation/option/store','API\Product\ProductVariationController@storeVarOpt')->name('admin.product.variation.option.store');
    Route::get('/product/get-variations-all','API\Product\ProductVariationController@getAll')->name('admin.product.variation.get-all');
    Route::get('/product/variation/option/all','API\Product\ProductVariationController@getProdVar')->name('admin.product.var.opt.get-all');
    
    Route::post('/product/image/store','API\Product\ProductVariationController@soreProdImg')->name('admin.product.var.image.get-all');
});


Route::prefix('frontend')->group(function () {
    Route::post('/products','API\Frontend\ProductController@getAll');
    Route::post('/products/featured','API\Frontend\ProductController@getByFeature');
    Route::post('/products/top-sell','API\Frontend\ProductController@getByTopSell');
    Route::get('/products/product-by-id','API\Frontend\ProductController@getById');
});