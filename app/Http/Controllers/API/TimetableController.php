<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Timetable;
use App\Http\Resources\TimetableResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class TimetableController extends Controller
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
        $studentId = $this->user->student_id;

        return TimetableResource::collection(Timetable::where('student_id', $studentId)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $studentId = $this->user->student_id;
        $request->merge(['student_id' => $studentId]);

        $request->validate([
            'course_name' => 'required|string',
            'class_type' => 'required|string',
            'day' => 'required|string',
            'start' => 'required',
            'end' => 'required'
        ]);

        $new_calendar = Timetable::create($request->all());
        return response()->json([
            'data' => new TimetableResource($new_calendar),
            'message' => 'Class added!',
            'status' => Response::HTTP_CREATED
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $class = Timetable::findOrFail($id);

        $request->validate([
            'course_name' => 'required|string',
            'class_type' => 'required|string',
            'day' => 'required|string',
            'start' => 'required',
            'end' => 'required'
        ]);

        $class->update($request->all());
        return response()->json([
            'data' => new TimetableResource($class),
            'message' => 'Timetable updated!',
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Timetable::findOrFail($id);
        $class->delete();
        return response('Class deleted!', Response::HTTP_NO_CONTENT);
    }
}
