<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'exam_name' => $this->exam_name,
            'exam_code' => $this->exam_code,
            'subject_id' => $this->subject_id,
            'subject_name' => $this->subject ? $this->subject->subject_name : null, // Check if subject is not null
            'subject_code' => $this->subject ? $this->subject->subject_code : null, // Check if subject is not null
        ];
    }
}
