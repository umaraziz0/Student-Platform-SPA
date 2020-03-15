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

Route::get('/admin', 'HomeController@admin');
Route::get('/admin/{path}', 'HomeController@admin')->where('path', '([A-z\d\-\/_.]+)?');

Route::get('/home', 'HomeController@index');
Route::get('{path}', 'HomeController@index')->where('path', '([A-z\d\-\/_.]+)?');
Route::get('/agenda/{path}', 'HomeController@index')->where('path', '([A-z\d\-\/_.]+)?');
    // fixes 404 error caused by trying to find a laravel page by fetching whatever values inside {path}
