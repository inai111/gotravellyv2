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
            'entity'=>'cities',
            'attributes'=>[
                'name'=>$this->name,
                'lat'=>$this->lat,
                'lng'=>$this->lng
            ]
        ];

        #
        $include = collect();

        $relationshipsStates = $this->whenLoaded('states',function(){
            # State singular
            return [
                'data'=>[
                    'id'=>$this->states->id,
                    'entity'=>"States"
                ]
            ];
        },false);
        if($relationshipsStates) {
            $include = $include->merge(StateResource::collection([$this->whenLoaded('states')]));
            $response['relationships']['states'] = $relationshipsStates;
        }

        #
        if(!$include->isEmpty()) $response['included'] = $include;


        return $response;
    }
}
