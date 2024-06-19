<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuardianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chat_id'=>$this->chat_id,
            'profile'=>$this->profile,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'gender'=>$this->gender,
            'date_of_birth'=>$this->date_of_birth,
            'phone_number'=>$this->phone_number,
            'address'=>$this->address,
        ];
    }
}
