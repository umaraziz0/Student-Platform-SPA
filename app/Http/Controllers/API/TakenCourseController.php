<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\TakenCourse;
use App\Course;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class TakenCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = TakenCourse::eloquentQuery($sortBy, $orderBy, $searchValue)
            ->paginate($length);

        return new DataTableCollectionResource($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $studentId = auth('api')->user()->student_id;
        $request->merge(['student_id' => $studentId]);

        $this->validate($request, [
            'course_id' => 'required|unique:taken_courses',
        ]);

        return TakenCourse::create([
            'student_id' => $request['student_id'],
            'course_id' => $request['course_id']
        ]);
    }

    public function getCourseName()
    {
        // used by [assignments] and [exams] page
        $studentId = auth('api')->user()->student_id;

        return TakenCourse::where('student_id', '=', $studentId)
            ->get();
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
