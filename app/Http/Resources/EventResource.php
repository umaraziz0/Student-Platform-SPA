<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'title' => $this->name,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'details' => $this->details
        ];
    }
}
