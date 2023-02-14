<?php

namespace App\Http\Resources\Client;

use App\Models\Visit;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Visit */
class ClientVisitsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'subscription' => $this->subscription,
            'hall' => $this->sale->hall,
            'trainer' => $this->trainer,
            'user' => $this->user,
            'time' => $this->sale->time,
            'date' => format_datetime($this->created_at)
        ];
    }
}
