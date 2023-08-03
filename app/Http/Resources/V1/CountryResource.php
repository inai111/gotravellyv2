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

        $include = collect();

        #
        $relationshipsStates = $this->whenLoaded('states',function(){
            return $this->states->map(function($state){
                return [
                    'data'=>[
                        'id'=>$state->id,
                        'type'=>"states"
                    ]
                ];
            });
        },false);
        if($relationshipsStates) {
            $include = $include->merge(StateResource::collection($this->whenLoaded('states')));
            $response['relationships']['states'] = $relationshipsStates;
        }

        #
        if(!$include->isEmpty()) $response['included'] = $include;

        return $response;
    }
}
