<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'role'=>$this->role,
            'profile'=>$this->profile,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'gender'=>$this->gender,
            'date_of_birth'=>$this->date_of_birth,
            'phone_number'=>$this->phone_number,
            'chat_id' => $this->guardian ? $this->guardian->chat_id : null,
            'address'=>$this->address,
            'parent_id'=>$this->guardian_id,
            'attendacnes' => AttendanceResource::collection($this->attendances),
            'comments' => CommentResource::collection($this->comments),
            'scores' => CommentResource::collection($this->scores),
            'subjects' => SubjectResurce::collection($this->subjects),
        ];
    }
}
