<?php

namespace App\Http\Resources\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'entity' => "invoices",
            'attributes' => [
                'customerId' => $this->customer_id,
                'amount' => $this->amount,
                'status' => $this->status,
                'billedDate' => $this->billed_date,
                'paidDate' => $this->paid_date
            ],
        ];

        $include = collect();

        $relationshipsCustomers = $this->whenLoaded('customers',function(){
            # customer singular
            return [
                'data'=>[
                    'id'=>$this->customert->id,
                    'entity'=>"customers"
                ]
            ];
        },false);
        if($relationshipsCustomers) {
            $include = $include->merge(CustomerResource::collection([$this->whenLoaded('customers')]));
            $response['relationships']['customers'] = $relationshipsCustomers;
        }

        #
        if(!$include->isEmpty()) $response['included'] = $include;

        return $response;
    }
}
