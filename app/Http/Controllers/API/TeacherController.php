<?php

namespace App\Http\Controllers\API;

use App\Course;
use App\Http\Controllers\Controller;
use App\TakenCourse;
use App\Teacher;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Intervention\Image\Facades\Image;

class TeacherController extends Controller
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

        $query = Teacher::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function storePhoto($request)
    {
        if ($request->photo) {
            $currentPhoto = $request->photo;
            // get the file and save it to a local directory
            $name = time() . '.' . explode('/', explode(":", substr($request->photo, 0, strpos($request->photo, ";")))[1])[1];

            Image::make($request->photo)->save(public_path('/img/teachers/') . $name);

            $request->merge(['photo' => $name]);

            $teacherPhoto = public_path('/img/teachers/') . $currentPhoto;
            if (file_exists($teacherPhoto)) {
                @unlink($teacherPhoto);
            }
        }
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

        $this->storePhoto($request);

        return Teacher::create([
            'teacher_id' => $request['teacher_id'],
            'name' => $request['name'],
            'title' => $request['title'],
            'photo' => $request['photo'],
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
    public function show(Request $request)
    {
        //
    }

    public function getTeachers(Request $request)
    {
        // require data from taken_courses table for current student
        // display filtered data from teachers table

        //! fix query

        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $takenCourses = Course::join('taken_courses', function ($join) {
            $studentId = auth('api')->user()->student_id;
            $join->on('courses.course_id', '=', 'taken_courses.course_id')
                ->where('taken_courses.student_id', '=', $studentId);
        })->select('courses.teacher_id');

        $query = Teacher::joinSub($takenCourses, 'taken', function ($join) {
            $join->on('teachers.teacher_id', '=', 'taken.teacher_id');
        })
            ->eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
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
            'phone' => 'nullable|numeric|digits_between:1,15|unique:teachers,phone,' . $teacher->id,
            'email' => 'nullable|email|unique:teachers,email,' . $teacher->id
        ]);

        $currentPhoto = $teacher->photo;

        if ($request->photo != $currentPhoto) {
            $this->storePhoto($request);
        }

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

    public function removePhoto($id)
    {
        $teacher = Teacher::findOrFail($id);

        $teacherPhoto = public_path('/img/teachers/') . $teacher->photo;
        if (file_exists($teacherPhoto)) {
            @unlink($teacherPhoto);
        }

        if ($teacher->photo != null) {
            $teacher->update(['photo' => null]);
        } else {
            abort(500, 'No photo uploaded.');
        }
    }
}
