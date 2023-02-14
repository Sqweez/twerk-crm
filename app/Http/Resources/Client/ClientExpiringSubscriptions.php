<?php

namespace App\Http\Resources\Client;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
/* @mixin Sale */
class ClientExpiringSubscriptions extends JsonResource
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
            'subscription' => $this->subscription,
            'active_until' => $this->active_until ? Carbon::parse($this->active_until)->format('d.m.Y') : null,
            'visits_remaining' => $this->visits_remaining,
            'current_trainer' => $this->trainer,
            'hall' => sprintf('%s (%s)', $this->hall->name, $this->time),
            'date' => format_datetime($this->created_at),
            'client_phone' => unmask_phone($this->client->phone),
        ];
    }
}
