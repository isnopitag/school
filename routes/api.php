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

/***
 * This middleware is for the JWT
 */
Route::group(['middleware' => ['jwt.auth']], function() {

    Route::post('/user/refresh', 'AuthController@refresh');

    Route::get('logout', 'AuthController@logout');

    Route::get('/user/test', function(){
        return response()->json(['foo'=>'bar']);
    });
});

/***
 *  ?
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/***
 * This Route its only to test Desktop Notifications at localhost:8000/api/user/noti
 */
Route::get('/notification', 'TestNotifications@sendToOneDevice');
