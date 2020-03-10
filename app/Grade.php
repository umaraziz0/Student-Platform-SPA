<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Grade extends Model
{
    use LaravelVueDatatableTrait;

    protected $fillable = [
        'student_id', 'course_id', 'grade', 'course_name'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'student_id' => [
            'searchable' => false,
        ],
        'course_id' => [
            'searchable' => true,
        ],
        'grade' => [
            'searchable' => true,
        ],
        'course_name' => [
            'searchable' => true
        ]
    ];

    protected $dataTableRelationships = [
        "belongsTo" => [
            'course' => [
                "model" => \App\Course::class,
                'foreign_key' => 'course_id',
                'columns' => [
                    'course_name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
        ],
    ];

    public function course()
    {
        return $this->belongsTo(\App\Course::class);
    }
}
