<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Assignment;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class AssignmentController extends Controller
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

        $query = Assignment::where('student_id', '=', $this->studentId)
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
        $request->merge(['student_id' => $this->student_id]);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'course_id' => 'required|numeric'
        ]);

        return Assignment::create([
            'student_id' => $request['student_id'],
            'name' => $request['name'],
            'course_id' => $request['course_id'],
            'due_date' => $request['due_date'],
            'details' => $request['details']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'course_id' => 'required|numeric'
        ]);

        $assignment->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
    }
}
