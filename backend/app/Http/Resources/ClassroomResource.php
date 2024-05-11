<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'classroom_name'=>$this->classroom_name,
            'student_count' => $this->student_count,
            'class_coordinator' => $this->teacherCoordinator ? $this->teacherCoordinator->first_name . ' ' . $this->teacherCoordinator->last_name : null,
        ];
    }
}
