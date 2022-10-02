<?php

namespace App\Http\Resources\Clients;

use App\Http\Resources\Client\ClientPurchasedServices;
use App\Models\Client;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Client */

class SingleClientResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'avatar' => $this->getFirstMediaUrl(),
            'sales' => ClientPurchasedServices::collection($this->sales),
        ];
    }
}
