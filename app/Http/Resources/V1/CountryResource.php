<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'type'=>'countries',
            'attributes'=>[
                'name'=>$this->name,
                'phoneCode'=>$this->phone_code,
                'timezone'=>$this->lng,
                'shortCode'=>$this->short_code,
            ]
        ];

        return $response;
    }
}
