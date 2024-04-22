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
            'profile'=>$this->profile,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            // 'chatId'=>$this->chatId,
            // 'phone_number'=>$this->phone_number,
            // 'address'=>$this->address,
            // 'classroomId'=>$this->classroomId,
            'attendacnes' => AttendanceResource::collection($this->attendances),
            'comments' => CommentResource::collection($this->comments),
            'scores' => CommentResource::collection($this->scores),
        ];
    }
}
