<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Exam;
use App\Todo;
use App\Event;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
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

        $assignments = Assignment::where('student_id', $studentId);
        $assignmentTotal = $assignments->count();

        $exams = Exam::where('student_id', $studentId);
        $examsTotal = $exams->count();

        $todos = Todo::where('student_id', $studentId);
        $todosTotal = $todos->count();

        $events = Event::where('student_id', $studentId);
        $eventsTotal = $events->count();

        return [
            'assignments' => $assignmentTotal,
            'exams' => $examsTotal,
            'tasks' => $todosTotal,
            'events' => $eventsTotal
        ];;
    }

    public function getUpcoming()
    {
        $studentId = $this->user->student_id;
        $today = Carbon::now();
        $week = Carbon::now()->addDays(7);

        $upcomingAssignments = Assignment::where('student_id', $studentId)
            ->whereBetween('due_date', [$today, $week])
            ->select('id', 'name', 'due_date')
            ->addSelect(DB::raw("'Assignment' as 'type'"))
            ->get();

        $upcomingExams = Exam::where('student_id', $studentId)
            ->whereBetween('date', [$today, $week])
            ->select('id', 'name', 'date AS due_date')
            ->addSelect(DB::raw("'Exam' as 'type'"))
            ->get();

        $result = $upcomingAssignments->merge($upcomingExams);

        return $result;
    }
}
