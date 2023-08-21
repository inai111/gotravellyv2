<?php

namespace App\Http\Resources\V1;

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
        $response = [
            'id'=>$this->id,
            'entity'=>'users',
            'attributes'=>[
                'name'=>$this->name,
                'email'=>$this->email,
            ]
        ];

        return $response;
    }
}
