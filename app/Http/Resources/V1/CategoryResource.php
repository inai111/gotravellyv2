<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'type'=>'categories',
            'attributes'=>[
                'name'=>$this->name,
                'active'=>$this->active,
                'priorityOrder'=>$this->priority_order
            ]
        ];

        #
        $include = collect();

        #
        if(!$include->isEmpty()) $response['included'] = $include;

        return $response;
    }
}
