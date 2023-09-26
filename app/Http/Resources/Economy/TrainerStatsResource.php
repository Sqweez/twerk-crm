<?php

namespace App\Http\Resources\Economy;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainerStatsResource extends JsonResource
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
            'date' => Carbon::parse($this->created_at)->format('d.m.Y H:i:s'),
            'user' => $this->user,
            'payment_type' => collect(Sale::PAYMENT_TYPES)->where('id', $this->payment_type)->first()['name'],
            'phone' => unmask_phone($this->client->phone),
        ];
    }
}
