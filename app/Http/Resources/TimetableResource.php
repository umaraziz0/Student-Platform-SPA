<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimetableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        date_default_timezone_set('Asia/Shanghai');
        $date = date("Y-m-d");

        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'title' => $this->course_name,
            'resourceId' => $this->day,
            'class_type' => $this->class_type,
            'start' => $date . ' ' . $this->start,
            'end' => $date . ' ' . $this->end,
            'room' => $this->room,
            'building' => $this->building,
            'details' => $this->details,
            'backgroundColor' => $this->color,
            'textColor' => $this->text_color,
        ];
    }
}
