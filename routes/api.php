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

});