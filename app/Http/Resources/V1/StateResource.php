<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
            'entity'=>'states',
            'attributes'=>[
                'name'=>$this->name,
            ]
        ];

        #
        $include = collect();

        #
        $countriesRelationships = $this->whenLoaded('countries',function(){
            return [
                'data'=>[
                    'id'=>$this->countries->id,
                    'entity'=>'countries'
                ]
            ];
        },false);
        if($countriesRelationships){
            $include = $include->merge(CountryResource::collection([$this->whenLoaded('countries')]));
            $response['relationships']['countries'] = $countriesRelationships;
        }

        #
        $citiesRelationships = $this->whenLoaded('cities',function(){
            return $this->cities->map(function($city){
                return [
                    'data'=>[
                        'id'=>$city->id,
                        'entity'=>'cities'
                    ]
                ];
            });
        },false);
        if($citiesRelationships){
            $include = $include->merge(CityResource::collection($this->whenLoaded('cities')));
            $response['relationships']['cities'] = $citiesRelationships;
        }

        #
        if(!$include->isEmpty()) $response['included'] = $include;
        return $response;
    }
}
