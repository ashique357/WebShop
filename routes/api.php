<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/get-users','API\RBACAccessApiController@getUsers')->name('get-user');
Route::post('/user-update','API\RBACAccessApiController@updateUser')->name('user-update');
Route::post('/user-create','API\RBACAccessApiController@createUser')->name('user-create');

Route::get('/get-roles','API\RBACAccessApiController@getRoles')->name('get-role');
Route::post('/role-update','API\RBACAccessApiController@updateRole')->name('role-update');
Route::post('/role-create','API\RBACAccessApiController@createRole')->name('role-create');

Route::get('/get-permissions','API\RBACAccessApiController@getPermissions')->name('get-permission');
Route::post('/permission-update','API\RBACAccessApiController@updatePermission')->name('permission-update');
Route::post('/permission-create','API\RBACAccessApiController@createPermission')->name('permission-create');

Route::post('/get-all-roles','API\RBACAccessApiController@getAllRoles')->name('get-all-roles');
Route::post('/get-all-permissions-old','API\RBACAccessApiController@getAllPermissionsOld')->name('get-all-permissions-old');

Route::post('/get-all-permissions-menu','API\RBACAccessApiController@getAllPermissionAsMenu')->name('get-all-permissions');

Route::post('/get-all-categories','CategoryController@getAllCategories')->name('get-all-categories');

Route::get('/get-categories','CategoryController@getCategories')->name('get-categories');
Route::post('/category-update','CategoryController@updateCategories')->name('categories-update');
Route::post('/category-create','CategoryController@createCategories')->name('categories-create');
