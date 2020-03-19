<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Teacher extends Model
{
    use LaravelVueDatatableTrait;
    //
    protected $guarded = [];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'teacher_id' => [
            'searchable' => true,
        ],
        'title' => [
            'searchable' => true,
        ],
        'photo' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'phone' => [
            'searchable' => true,
        ],
        'email' => [
            'searchable' => true,
        ],
        'office_address' => [
            'searchable' => true,
        ],
        'office_hours' => [
            'searchable' => true,
        ],
        'courses_taught' => [
            'searchable' => true,
        ]
    ];
}
