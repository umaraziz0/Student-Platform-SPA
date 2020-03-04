<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\TakenCourse;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Illuminate\Support\Facades\Validator;

class TakenCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();

        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = TakenCourse::where('student_id', $user->student_id)
            ->eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();
        $studentId = $user->student_id;
        $request->merge(['student_id' => $studentId]);

        $validatedData = $request->validate([
            'course_id' => 'required|unique:taken_courses',
            'course_name' => 'required|unique:taken_courses'
        ]);

        return TakenCourse::create([
            'student_id' => $request['student_id'],
            'course_id' => $request['course_id'],
            'course_name' => $request['course_name'],
            'credits' => $request['credits'],
            'teacher' => $request['teacher']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TakenCourse  $takenCourse
     * @return \Illuminate\Http\Response
     */
    public function show(TakenCourse $takenCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TakenCourse  $takenCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TakenCourse $takenCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TakenCourse  $takenCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = TakenCourse::findOrFail($id);
        $course->delete();
    }
}
