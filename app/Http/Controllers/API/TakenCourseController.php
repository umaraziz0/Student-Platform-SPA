<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\TakenCourse;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class TakenCourseController extends Controller
{
    public function __construct()
    {
        $this->studentId = auth('api')->user()->student_id;
    }

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

        $query = TakenCourse::where('student_id', '=', auth('api')->user()->student_id)
            ->eloquentQuery($sortBy, $orderBy, $searchValue)
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
        $request->merge(['student_id' => $this->studentId]);

        $this->validate($request, [
            'course_id' => 'required|unique:taken_courses,course_id,NULL,id,student_id,3',
        ]);

        return TakenCourse::create([
            'student_id' => $request['student_id'],
            'course_id' => $request['course_id']
        ]);
    }

    public function getCourseName()
    {
        // used by [assignments] and [exams] page
        return TakenCourse::where('student_id', '=', $this->studentId)
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
