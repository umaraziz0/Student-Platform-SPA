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

Route::get('/admin/{name}', 'AdminController@show');
Route::get('admin', 'AdminController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}', 'HomeController@index')->where( 'path' , '([A-z\d\-\/_.]+)?' );
    // fixes 404 error caused by trying to find a laravel page

// Route::get('/assignments', 'AssignmentController@index')->name('assignments');
