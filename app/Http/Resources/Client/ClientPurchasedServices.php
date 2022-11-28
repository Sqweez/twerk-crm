<?php

namespace App\Http\Resources\Client;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Sale */

class ClientPurchasedServices extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subscription_name' => $this->subscription->name,
            'subscription_type' => $this->subscription->type->name,
            'active_until' => $this->active_until ? Carbon::parse($this->active_until)->format('d.m.Y') : null,
            'is_activated' => $this->is_activated,
            'visits_remaining' => $this->visits_remaining,
            'current_trainer' => $this->trainer,
            'is_active' => $this->is_active,
            'sale_date' => format_datetime($this->created_at),
        ];
    }
}
