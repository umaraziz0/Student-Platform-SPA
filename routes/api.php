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
        'assignment' => 'API\AssignmentController',
        'exam' => 'API\ExamController',
        'course' => 'API\CourseController',
        'takencourse' => 'API\TakenCourseController',
        'teacher' => 'API\TeacherController',
        'grade' => 'API\GradeController',
        'todo' => 'API\TodoController',
        'calendar' => 'API\EventController',
        'timetable' => 'API\TimetableController',
        'dashboard' => 'API\DashboardController'
    ]);
});

// Route::apiResource('user', 'API\UserController');

Route::group(['middleware' => 'auth:api'], function () {
    //define new routes for new methods
    Route::get('profile', 'API\UserController@profile');
    Route::put('profile', 'API\UserController@updateProfile');
    Route::delete('removePhoto/{id}', 'API\UserController@removePhoto');
    //Route::get('studentid', 'API\UserController@getId');

    // routes for getting single user info
    Route::get('teachers', 'API\TeacherController@getTeachers');
    Route::delete('removeTeacherPhoto/{id}', 'API\TeacherController@removePhoto');

    Route::get('grades', 'API\GradeController@getGrades');

    Route::put('todoCheckAll', 'API\TodoController@checkAll');
    Route::delete('todoClearCompleted', 'API\TodoController@clearCompleted');

    Route::get('getUpcoming', 'API\DashboardController@getUpcoming');
});
