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

// Route::get('/admin', 'HomeController@admin')->middleware('isAdmin');
// Route::get('/admin/{path}', 'HomeController@admin')->where('path', '([A-z\d\-\/_.]+)?');

Route::get('/home', 'HomeController@index');

// Route::group(['middleware' => 'isAdmin'], function () {
//     Route::get('admin-dashboard', 'HomeController@index');
//     Route::get('users', 'HomeController@index');
//     Route::get('edit-courses', 'HomeController@index');
//     Route::get('edit-profile', 'HomeController@index');
//     Route::get('edit-courses', 'HomeController@index');
// });

Route::get('admin/{path}', 'HomeController@index')->where('path', '.*')->middleware('isAdmin');
Route::get('agenda/{path}', 'HomeController@index')->where('path', '.*');

Route::get('{path}', 'HomeController@index')->where('path', '.*');
// fixes 404 error caused by trying to find a laravel page by fetching whatever values inside {path}
