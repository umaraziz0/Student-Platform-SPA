<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\TaughtCourse;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class CourseController extends Controller
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

        $query = Course::eloquentQuery($sortBy, $orderBy, $searchValue)
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
            'course_id' => 'required|numeric|unique:courses',
            'course_name' => 'required|string|unique:courses',
            'credits' => 'required|numeric',
        ]);

        $course =  Course::create([
            'course_id' => $request['course_id'],
            'course_name' => $request['course_name'],
            'credits' => $request['credits'],
        ]);

        return response(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $this->validate($request, [
            'course_id' => 'required|numeric|unique:courses,course_id,' . $course->id,
            'course_name' => 'required|string|unique:courses,course_name,' . $course->id,
            'credits' => 'required|numeric',
        ]);

        $course->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
    }
}
