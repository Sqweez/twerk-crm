<?php

namespace App\Http\Resources\Clients;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'client_name' => sprintf("%s %s", $this->name, $this->surname),
            'pass_expired_at' => $this->pass_expired_at,
            'purchase_date' => $this->purchase_date,
            'expire_date' => $this->pass_expired_at ? Carbon::parse($this->pass_expired_at)->format('d.m.Y') : '-',
            'purchase_date_format' => $this->purchase_date ? Carbon::parse($this->purchase_date)->format('d.m.Y') : '-',
            'phone' => $this->phone,
            'user' => $this->user,
        ];
    }
}
