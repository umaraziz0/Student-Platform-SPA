<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Todo::where('student_id', $this->user->student_id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['student_id' => $this->user->student_id]);

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

    public function checkAll(Request $request)
    {
        $data = $request->validate([
            'isCompleted' => 'required|boolean'
        ]);

        // $todo->update($data);

        Todo::query()->where('student_id', $this->user->student_id)->update($data);

        return response('All items checked.', 200);
    }

    public function clearCompleted(Request $request)
    {
        $request->validate([
            'todos' => 'required|array'
        ]);

        Todo::destroy($request->todos);

        return response('Completed items cleared.', 200);
    }
}
