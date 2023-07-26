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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'gender'=>$this->gender,
            'age'=>$this->age,
            'date_of_birth'=>$this->date_of_birth,
            'phone_number'=>$this->phone_number,
            'address'=>$this->address,
            'job'=>$this->job,
        ];
    }
}
