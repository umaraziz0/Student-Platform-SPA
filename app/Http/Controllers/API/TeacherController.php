<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Teacher;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();

        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Teacher::eloquentQuery($sortBy, $orderBy, $searchValue);

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
        $this->validate($request, [
            'teacher_id' => 'required|numeric|unique:teachers',
            'name' => 'required|string|unique:teachers',
            'phone' => 'nullable|numeric|unique:teachers',
            'email' => 'nullable|email|unique:teachers'
        ]);

        return Teacher::create([
            'teacher_id' => $request['teacher_id'],
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'office_address' => $request['office_address'],
            'office_hours' => $request['office_hours'],
            'courses_taught' => $request['courses_taught']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $this->validate($request, [
            'teacher_id' => 'required|numeric|unique:teachers,teacher_id,' . $teacher->id,
            'name' => 'required|string|unique:teachers,name,' . $teacher->id,
            'phone' => 'nullable|numeric|unique:teachers,phone,' . $teacher->id,
            'email' => 'nullable|email|unique:teachers,email,' . $teacher->id
        ]);

        $teacher->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
    }
}
