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

        $courses = Course::leftJoin('teachers', function ($join) {
            $join->on('courses.teacher_id', '=', 'teachers.teacher_id');
        })
            ->select('courses.course_id', 'courses.course_name', 'courses.credits', 'teachers.name');

        $takenCourses = TakenCourse::leftJoinSub($courses, 'c', function ($join) {
            $join->on('taken_courses.course_id', 'c.course_id')
                ->where('taken_courses.student_id', '=', auth('api')->user()->student_id);
        })->select('taken_courses.*', 'c.course_name', 'c.credits', 'c.name')
            ->where('taken_courses.course_id', 'LIKE', "%$searchValue%")
            ->orWhere('c.course_name', 'LIKE', "%$searchValue%")
            ->orWhere('c.credits', 'LIKE', "%$searchValue%")
            ->orderBy($sortBy, $orderBy)
            ->paginate($length);

        return new DataTableCollectionResource($takenCourses);
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
