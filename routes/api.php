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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        //后台接口
        Route::group(['prefix' => 'backstage'], function () {
            Route::get('/admin', 'V1\Backstage\AdminController@index');  //管理员列表
            Route::post('/admin', 'V1\Backstage\AdminController@store'); //新增管理员
            Route::put('/admin', 'V1\Backstage\AdminController@update'); //更新管理员
            Route::delete('/admin', 'V1\Backstage\AdminController@destroy'); //删除管理员
        });
    });
});
