<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Student;
use Intervention\Image\Exception\NotReadableException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Student::create([
            'student_id' => $request['student_id'],
        ]);
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

    public function profile()
    {
        //get authenticated user info
        $user =  auth('api')->user();
        $student = Student::where('student_id', $user->student_id)->firstOrFail();

        return $student;
    }

    public function updateProfile(Request $request)
    {
        $user =  auth('api')->user();
        $student = Student::where('student_id', $user->student_id)->firstOrFail();

        $this->validate($request, [
            'year' => 'nullable|integer|min:1950|max:2020'
        ]);

        $currentPhoto = $student->photo;

        // $thePhoto =  public_path('img/profile/') . $currentPhoto;
        // if (!file_exists($thePhoto)) {
        //     $request->merge(['photo' => 'default.png']);
        // }

        if ($request->photo != $currentPhoto) {
            // get the file and save it to a local directory
            $name = time() . '.' . explode('/', explode(":", substr($request->photo, 0, strpos($request->photo, ";")))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/') . $name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/') . $currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }

        $student->update($request->all());
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

    public function removePhoto()
    {
        $user =  auth('api')->user();
        $photo = Student::where('student_id', $user->student_id)->firstOrFail();

        $userPhoto = public_path('img/profile/') . $photo->photo;
        if (file_exists($userPhoto)) {
            @unlink($userPhoto);
        }

        $photo->update(['photo' => null]);

        return [
            'message' => 'photo deleted.'
        ];
    }
}
