<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Assignment extends Model
{
    use LaravelVueDatatableTrait;
    //
    protected $fillable = [
        'student_id', 'name', 'course_name', 'due_date', 'details'
    ];

    protected $dataTableColumns = [
        'name' => [
            'searchable' => false,
        ],
        'course_name' => [
            'searchable' => true,
        ],
        'due_date' => [
            'searchable' => true,
        ],
        'details' => [
            'searchable' => true,
        ]
    ];
}
