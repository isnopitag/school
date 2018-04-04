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

/***
 * API JWT Integration Testing Routes this Routes needs api prefix before call it on
 * web browser or Postman like this: "localhost:8000/api/user/login"
 */
Route::post('/user/register', 'AuthController@register');

Route::post('/user/login', 'AuthController@login');

Route::post('/user/logout', 'AuthController@logout');

Route::post('/user/refresh', 'AuthController@refresh');


Route::get('/notification', 'TestNotifications@send');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::post('auth/logout', 'AuthController@logout');
});
