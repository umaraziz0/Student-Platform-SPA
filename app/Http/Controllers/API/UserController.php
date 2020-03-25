<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Major;
use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class UserController extends Controller
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

        $query = User::eloquentQuery($sortBy, $orderBy, $searchValue);

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
            'name' => 'required|string|max:255',
            'student_id' => 'required|integer|digits_between:1,12|unique:users',
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'required|string|min:6',
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
        $user = User::findOrFail($id);

        return $user;
    }

    public function profile()
    {
        //return authenticated user data
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        //updates the user data and profile

        $user =  User::findOrFail($request->id);

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

            Image::make($request->photo)->save(public_path('/img/profile/') . $name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('/img/profile/') . $currentPhoto;
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

    public function removePhoto($id)
    {
        $user = User::findOrFail($id);

        $userPhoto = public_path('/img/profile/') . $user->photo;
        if (file_exists($userPhoto)) {
            @unlink($userPhoto);
        }

        if ($user->photo != null) {
            $user->update(['photo' => null]);
        } else {
            abort(500, 'No photo uploaded.');
        }
    }
}
