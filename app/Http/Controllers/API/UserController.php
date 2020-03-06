<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    public function getId()
    {
        $studentid = auth('api')->user()->student_id;

        return $studentid;
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
            'name' => 'required|string|max:255',
            'student_id' => 'required|integer|digits_between:1,12|unique:users',
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);

        return User::create([
            'name' => $request['name'],
            'student_id' => $request['student_id'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'is_admin' => $request['is_admin']
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
        //return authenticated user info
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user =  auth('api')->user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'student_id' => 'required|integer|digits_between:1,12|unique:users,student_id,' . $user->id, // requires unique values except itself
            'email' => 'nullable|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'year' => 'nullable|integer|min:1900|max:2020',
            'phone' => 'nullable|integer|unique:users,phone,' . $user->id
        ]);

        $currentPhoto = $user->photo;

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

        if (!empty($request->password)) {
            $request->merge(['password' =>  Hash::make($request['password'])]);
        }

        if (empty($request->password)) {
            $request->merge(['password' => $user->password]);
        }

        $user->update($request->all());

        return ['message' => 'success'];
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
        //updates the user info
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'student_id' => 'required|numeric|digits_between:1,12|unique:users,student_id,' . $user->id,
            'email' => 'nullable|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        if (!empty($request->password)) {
            $request->merge(['password' =>  Hash::make($request['password'])]);
        }

        if (empty($request->password)) {
            $request->merge(['password' => $user->password]);
        }

        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // deletes the user
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function removePhoto()
    {
        $user =  auth('api')->user();

        $userPhoto = public_path('img/profile/') . $user->photo;
        if (file_exists($userPhoto)) {
            @unlink($userPhoto);
        }

        $user->update(['photo' => null]);

        return [
            'message' => 'photo deleted.'
        ];
    }
}
