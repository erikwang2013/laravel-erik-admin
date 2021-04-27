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
Route::get('/admin', 'V1\Admin\AdminController@index');
Route::post('/admin', 'V1\Admin\AdminController@store');
Route::put('/admin', 'V1\Admin\AdminController@update');
Route::delete('/admin', 'V1\Admin\AdminController@destroy');