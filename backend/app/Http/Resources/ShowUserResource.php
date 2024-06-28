<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowUserResource extends JsonResource
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
            'age'=>$this->age,
            'gender'=>$this->gender,
            'date_of_birth'=>$this->date_of_birth,
            'phone_number'=>$this->phone_number,
            'chat_id' => $this->guardian ? $this->guardian->chat_id : null,
            'address'=>$this->address,
            'parent_id'=>$this->guardian_id,
            'classroom_id'=>$this->classroom_id,
            'subjects' => $this->subjects->pluck('id'),// Extract only the IDs
            'guardian' => new GuardianResource($this->guardian),
            'classroom' => ClassroomResource::collection($this->classrooms),
        ];
    }
}
