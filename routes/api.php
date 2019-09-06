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
Route::post('/user/register', 'AuthController@register');
Route::post('/user/login', 'AuthController@login');

Route::get('careers','CareerController@index');

Route::get('status','StatusController@index');

Route::prefix('auth')->group(function () {

});

Route::prefix('teachers')->group(function () {
    Route::get('/','UserController@indexTeachers');
});

Route::prefix('students')->group(function () {

});