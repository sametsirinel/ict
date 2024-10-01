<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'order' => [    
                "order_no" => $this->order_no,
                "order_date" => $this->order_date,
                "status_id" => $this->status->status,
                "shipment_address" => $this->shipment_address,
            ],
            'customer' => (new CustomerResource($this->customer)),
            'products' => OrderProductResource::collection($this->products),
        ];
    }
}
