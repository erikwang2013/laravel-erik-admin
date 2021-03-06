<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
Route::group(['prefix' => 'v1'], function () {
    Route::post('/backstage/login', 'V1\Backstage\PublicController@login');  //登录
    //后台接口 middleware('backstage')->
    Route::group(['prefix' => 'backstage', 'middleware' => 'backstage'], function () {
        Route::get('/admin', 'V1\Backstage\AdminController@index');  //管理员列表
        Route::post('/admin', 'V1\Backstage\AdminController@store'); //新增管理员
        Route::put('/admin/{id}', 'V1\Backstage\AdminController@update'); //更新管理员
        Route::delete('/admin', 'V1\Backstage\AdminController@destroy'); //删除管理员

        Route::post('/admin/role', 'V1\Backstage\AdminController@roleStore'); //管理员分配角色
        Route::put('/admin/role/{id}', 'V1\Backstage\AdminController@roleUpdate'); //更新管理员角色
        Route::delete('/admin/role', 'V1\Backstage\AdminController@roleDestroy'); //删除管理员角色

        Route::get('/logout', 'V1\Backstage\PublicController@logout');  //登出

        Route::get('/authority', 'V1\Backstage\AuthorityController@index');  //权限列表
        Route::post('/authority', 'V1\Backstage\AuthorityController@store'); //新增权限
        Route::put('/authority/{id}', 'V1\Backstage\AuthorityController@update'); //更新权限
        Route::delete('/authority', 'V1\Backstage\AuthorityController@destroy'); //删除权限
        Route::get('/authority/parent', 'V1\Backstage\AuthorityController@parentData'); //父级权限列表

        Route::get('/role', 'V1\Backstage\RoleController@index');  //角色列表
        Route::post('/role', 'V1\Backstage\RoleController@store'); //新增角色
        Route::put('/role/{id}', 'V1\Backstage\RoleController@update');  //更新角色
        Route::delete('/role', 'V1\Backstage\RoleController@destroy'); //删除角色
    });
});
//});
