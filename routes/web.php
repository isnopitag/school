<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

/***
 * JWT Integration, I guess...
 */
Route::post('signup', 'AuthController@register');

Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'AuthController@user');
});

Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');

/***
Route::group(['prefix' => 'web'], function () {
    Route::get('/homeroot','HomeController@Homeroot')->name('homeroot');

    Route::get('/homeadmin','HomeController@HomeSuperAdmin')->name('homeadmin');

    Route::get('/homeclient','HomeController@HomeeClient')->name('homeadmin');
});*/
