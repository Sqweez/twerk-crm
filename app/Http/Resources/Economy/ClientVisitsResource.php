<?php

namespace App\Http\Resources\Economy;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Visit */

class ClientVisitsResource extends JsonResource
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
            'client' => $this->client,
            'trainer' => $this->trainer,
            'subscription' => $this->subscription,
            'user' => $this->user,
            'date' => Carbon::parse($this->created_at)->format('d.m.Y H:i:s'),
        ];
    }
}
