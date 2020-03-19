<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Grade;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // adding course_name and user name columns to the edit grades table

        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Grade::join('users', 'grades.student_id', '=', 'users.student_id')
            ->join('courses', 'grades.course_id', '=', 'courses.course_id')
            ->select('grades.*', 'courses.course_name', 'users.name')->orderBy($sortBy, $orderBy)
            ->where('grades.student_id', 'LIKE', "%$searchValue%")
            ->orWhere('grades.course_id', 'LIKE', "%$searchValue%")
            ->orWhere('grades.grade', 'LIKE', "%$searchValue%")
            ->orWhere('courses.course_name', 'LIKE', "%$searchValue%")
            ->orWhere('users.name', 'LIKE', "%$searchValue%");

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function getGrades(Request $request)
    {
        // require course_name column from courses table

        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Grade::join('courses', function ($join) {
            $join->on('grades.course_id', '=', 'courses.course_id')
                ->where('grades.student_id', '=', auth('api')->user()->student_id);
        })
            ->select('grades.*', 'courses.course_name')
            ->where('grades.course_id', 'LIKE', "%$searchValue%")
            ->orWhere('grades.grade', 'LIKE', "%$searchValue%")
            ->orWhere('courses.course_name', 'LIKE', "%$searchValue%")
            ->orderBy($sortBy, $orderBy)
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
            'student_id' => 'required|numeric',
            'course_id' => 'required|numeric',
            'grade' => 'required|numeric',
        ]);

        return Grade::create([
            'course_id' => $request['course_id'],
            'student_id' => $request['student_id'],
            'grade' => $request['grade'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $grade = Grade::findOrFail($id);

        $this->validate($request, [
            'student_id' => 'required|numeric',
            'course_id' => 'required|numeric',
            'grade' => 'required|numeric',
        ]);

        $grade->update([
            'course_id' => $request['course_id'],
            'student_id' => $request['student_id'],
            'grade' => $request['grade'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();
    }
}
