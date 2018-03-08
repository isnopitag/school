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
 /* 
Route::get('/', function () {
    return view('welcome');
});
  **/

Route::any('/{all}', function () {
    return view('welcome');
})
->where(['all' => '.*']);

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'web'], function () {
    Route::get('/homeroot','HomeController@Homeroot')->name('homeroot');

    Route::get('/homeadmin','HomeController@HomeSuperAdmin')->name('homeadmin');

    Route::get('/homeclient','HomeController@HomeeClient')->name('homeadmin');
});
