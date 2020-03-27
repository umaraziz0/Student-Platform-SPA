<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Exam;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class ExamController extends Controller
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

        $query = Exam::where('student_id', '=', $this->studentId)
            ->eloquentQuery($sortBy, $orderBy, $searchValue)
            ->paginate($length);

        return new DataTableCollectionResource(
            $query
        );
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
            'name' => 'required|string|max:255',
            'course_id' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        return Exam::create([
            'name' => $request['name'],
            'student_id' => $request['student_id'],
            'course_id' => $request['course_id'],
            'date' => $request['date'],
            'time' => $request['time'],
            'room' => $request['room'],
            'building' => $request['building'],
            'details' => $request['details']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'course_id' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        $exam->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
    }
}
