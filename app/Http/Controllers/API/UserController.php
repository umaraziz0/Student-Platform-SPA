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
            'student_id' => 'required|integer|max:11|unique:users',
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
            'student_id' => 'integer|required|digits_between:1,12|unique:users,student_id,' . $user->id,
            'email' => 'nullable|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        if (!empty($request->password)) {
            $request->merge(['password' =>  Hash::make($request['password'])]);
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
            'student_id' => 'required|integer|max:11|unique:users,student_id,' . $user->id,
            'email' => 'nullable|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:6',
        ]);

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
}
