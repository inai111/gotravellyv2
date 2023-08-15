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
            'entity'=>'countries',
            'attributes'=>[
                'name'=>$this->name,
                'phoneCode'=>$this->phone_code,
                'timezone'=>$this->lng,
                'shortCode'=>$this->short_code,
            ]
        ];

        $include = collect();

        $relationshipsContinents = $this->whenLoaded('continents',function(){
            # continent singular
            return [
                'data'=>[
                    'id'=>$this->continents->id,
                    'entity'=>"continents"
                ]
            ];
        },false);
        if($relationshipsContinents) {
            $include = $include->merge(ContinentsResource::collection([$this->whenLoaded('continents')]));
            $response['relationships']['continents'] = $relationshipsContinents;
        }
        
        #
        $relationshipsStates = $this->whenLoaded('states',function(){
            # states plural
            return $this->states->map(function($state){
                return [
                    'data'=>[
                        'id'=>$state->id,
                        'entity'=>"states"
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
