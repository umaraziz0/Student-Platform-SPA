<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Assignment extends Model
{
    use LaravelVueDatatableTrait;
    //
    protected $guarded = [];

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
        'due_date' => [
            'searchable' => true,
        ],
        'details' => [
            'searchable' => true,
        ],
        'course_id' => [
            'searchable' => true,
        ],
    ];

    public function getCourseNameAttribute()
    {
        return Course::where('course_id', '=', $this->course_id)
            ->pluck('course_name');
    }

    protected $appends = ['course_name'];
}
