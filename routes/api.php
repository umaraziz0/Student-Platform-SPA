<?php

use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {

    Route::apiResources([

        'user' => 'API\UserController',
        'student' => 'API\StudentController'

    ]);
});

// Route::apiResource('user', 'API\UserController');

//define new routes for new methods
Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');

Route::get('extra', 'API\StudentController@profile');
Route::put('extra', 'API\StudentController@updateProfile');

Route::put('removePhoto', 'API\StudentController@removePhoto');
