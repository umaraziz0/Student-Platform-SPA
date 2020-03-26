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

Route::get('/home', 'HomeController@index');

Route::get('/dashboard', 'DashboardController@index');
Route::get('/upcoming', 'DashboardController@getUpcoming');

Route::get('admin/{path}', 'HomeController@index')->where('path', '.*')->middleware('isAdmin');
Route::get('agenda/{path}', 'HomeController@index')->where('path', '.*');

Route::get('/{path}', 'HomeController@index')->where('path', '.*');
// fixes 404 error caused by trying to find a laravel page by fetching whatever values inside {path}
