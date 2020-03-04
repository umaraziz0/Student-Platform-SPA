<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Exam extends Model
{
    use LaravelVueDatatableTrait;
    //
    protected $fillable = [
        'student_id', 'name', 'course_name', 'date', 'time', 'room', 'building', 'details'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'student_id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'course_name' => [
            'searchable' => true,
        ],
        'date' => [
            'searchable' => true,
        ],
        'time' => [
            'searchable' => true,
        ],
        'room' => [
            'searchable' => true,
        ],
        'building' => [
            'searchable' => true,
        ],
        'details' => [
            'searchable' => true,
        ]
    ];
}
