<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\TaughtCourse;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class TaughtCourseController extends Controller
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

        $query = TaughtCourse::eloquentQuery($sortBy, $orderBy, $searchValue)
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
        $this->validate($request, [
            'course_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
        ]);

        return TaughtCourse::create([
            'course_id' => $request['course_id'],
            'teacher_id' => $request['teacher_id'],
        ]);
    }

    public function getCourseName()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaughtCourse  $taughtCourse
     * @return \Illuminate\Http\Response
     */
    public function show(TaughtCourse $taughtCourse)
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
    public function update(Request $request, $id)
    {
        $course = TaughtCourse::findOrFail($id);

        $this->validate($request, [
            'course_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
        ]);

        $course->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TakenCourse  $takenCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = TaughtCourse::findOrFail($id);
        $course->delete();
    }
}
