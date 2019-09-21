<?php

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

Route::post('/user/login', 'AuthController@login');
Route::get('/user/logout', 'AuthController@logout');

Route::get('careers','CareerController@index');
Route::post('careers','CareerController@store');

Route::get('status','StatusController@index');
Route::post('status','StatusController@store');

Route::post('/user/register', 'UserController@store');
Route::put('/user/{id}', 'UserController@update');
Route::get('/user', 'UserController@show');
Route::delete('/user/{id}', 'UserController@destroy');

Route::prefix('auth')->group(function () {

});

Route::prefix('teachers')->group(function () {
    Route::get('/','UserController@indexTeachers');
});

Route::prefix('students')->group(function () {

});