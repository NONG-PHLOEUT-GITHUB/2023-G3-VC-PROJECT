<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'student_id' => $this->user_id,
            'teacher_id' => $this->teacher_id,
            'teacher_profile'=>$this->teacher->profile,
            'teacher_fullname'=>$this->teacherFullname,
            'student_name'=>$this->student
        ];
    }
}
