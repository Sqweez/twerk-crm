<?php

namespace App\Http\Resources\User;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Sale */
class UserActiveSubscriptionsResource extends JsonResource
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
            'subscription_name' => $this->subscription->name,
            'subscription_type_id' => $this->subscription->type_id,
            'subscription_type' => $this->subscription->type->name,
            'active_until' => $this->active_until ? Carbon::parse($this->active_until)->format('d.m.Y') : null,
            'is_activated' => $this->is_activated,
            'visits_remaining' => $this->visits_remaining,
            'is_active' => $this->is_active,
            'sale_date' => format_datetime($this->created_at),
            'client' => $this->client,
            'subscription' => $this->subscription,
            'price' => $this->price,
            'user' => $this->user,
            'payment_type' => $this->payment_type_name,
            'date' => Carbon::parse($this->created_at)->format('d.m.Y H:i:s'),
        ];
    }
}
