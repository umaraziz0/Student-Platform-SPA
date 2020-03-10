<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public $user;
    public $studentId;

    public function __construct()
    {
        $this->user = auth('api')->user();
        $this->studentId = $this->user->student_id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Todo::where('student_id', $this->studentId)->get();
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

        $data = $request->validate([
            'student_id' => 'required|numeric',
            'title' => 'required|string',
            'isCompleted' => 'required|boolean',
        ]);

        $todo = Todo::create($data);

        return response($todo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'isCompleted' => 'required|boolean'
        ]);

        $todo->update($data);

        return response($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response('Deleted item', 200);
    }
}
