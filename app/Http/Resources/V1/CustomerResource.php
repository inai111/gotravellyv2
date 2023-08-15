<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'entity' => "customers",
            'attributes' => [
                'name' => $this->name,
                'type' => $this->type,
                'email' => $this->email,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'postalCode' => $this->postal_code,
            ],
        ];

        $include = collect();

        #
        $relationshipsInvoices = $this->whenLoaded('invoices',function(){
            # invoices plural
            return $this->invoices->map(function($invoice){
                return [
                    'data'=>[
                        'id'=>$invoice->id,
                        'entity'=>"invoices"
                    ]
                ];
            });
        },false);
        if($relationshipsInvoices) {
            $include = $include->merge(InvoiceResource::collection($this->whenLoaded('invoices')));
            $response['relationships']['invoices'] = $relationshipsInvoices;
        }

        #
        if(!$include->isEmpty()) $response['included'] = $include;

        return $response;
    }
}
