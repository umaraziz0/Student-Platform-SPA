<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\EventResource;
use App\Http\Controllers\Controller;
use App\Event;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
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

        return EventResource::collection(Event::where('student_id', $studentId)->get());
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

        //! validation

        $new_calendar = Event::create($request->all());
        return response()->json([
            'data' => new EventResource($new_calendar),
            'message' => 'Event added!',
            'status' => Response::HTTP_CREATED
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $studentId = $this->user->student_id;
        $request->merge(['student_id' => $studentId]);

        //! validation

        $event->update($request->all());
        return response()->json([
            'data' => new EventResource($event),
            'message' => 'Event updated!',
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response('Event deleted!', Response::HTTP_NO_CONTENT);
    }
}
