<?php

use Illuminate\Http\Request;

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



});


Route::resource('members', 'MemberAPIController');
Route::get('send', 'MemberAPIController@rabbitMQ_Send');
Route::get('receive', 'MemberAPIController@rabbitMQ_receive');
Route::post('login', 'AuthController@issueToken');


Route::resource('users', 'UserAPIController');

Route::group(['middleware' => 'auth:api'], function () {

});

Route::resource('members', 'MemberAPIController');
Route::resource('configurations', 'ConfigurationAPIController');

