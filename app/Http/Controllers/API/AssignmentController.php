<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = auth('api')->user();

        return Assignment::where('student_id', $user->student_id)->latest()->paginate(10);
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

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'course_name' => 'required|string'
        ]);

        return Assignment::create([
            'student_id' => $request['student_id'],
            'name' => $request['name'],
            'course_name' => $request['course_name'],
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
            'course_name' => 'required|string'
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
