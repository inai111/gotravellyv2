<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'type'=>'cities',
            'attributes'=>[
                'name'=>$this->name,
                'lat'=>$this->lat,
                'lng'=>$this->lng
            ]
        ];

        #
        $include = collect();

        #
        if($include->isEmpty()) $response['included'] = $include;

        return $response;
    }
}
