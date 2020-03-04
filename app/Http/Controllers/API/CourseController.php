<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
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

        $query = Course::eloquentQuery($sortBy, $orderBy, $searchValue);

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCourses(Request $request)
    {
        if ($request->input('showdata')) {
            return Course::orderBy('created_at', 'desc')->get();
        }
        $columns = ['course_id', 'course_name', 'credits', 'teacher'];
        $length = $request->input('length');
        $column = $request->input('column');
        $search_input = $request->input('search');
        $query = Course::select('course_id', 'course_name', 'credits', 'teacher')->orderBy($columns[$column]);
        if ($search_input) {
            $query->where(function ($query) use ($search_input) {
                $query->where('course_name', 'like', '%' . $search_input . '%')
                    ->orWhere('teacher', 'like', '%' . $search_input . '%')
                    ->orWhere('credits', 'like', '%' . $search_input . '%');
            });
        }
        $courses = $query->paginate($length);
        return ['data' => $courses];
    }
}
