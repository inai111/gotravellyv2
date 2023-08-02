<?php

namespace App\Http\Resources\V1;

use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ContinentsResource extends JsonResource
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
            'type'=>'continents',
            'attributes'=>[
                'name'=>$this->name
            ]
        ];

        # inisial collection kosong di var include
        $include = collect();
        
        # cek apakah include countries
        $relationshipsCountries = $this->whenLoaded('countries',function(){
            return $this->countries->map(function($country){
                return [
                    'data'=>[
                        'id'=>$country->id,
                        'type'=>'countries'
                    ]
                ];
            });
        },false);
        if($relationshipsCountries) {
            $include = $include->merge(CountryResource::collection($this->whenLoaded('countries')));
            $response['relationships']['countries'] = $relationshipsCountries;
        }

        #cek apakah collection include ada isinya
        if(!$include->isEmpty()){
            $response['included'] = $include;
        }
        
        return $response;
    }
}
