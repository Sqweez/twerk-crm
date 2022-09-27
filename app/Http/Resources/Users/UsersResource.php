<?php

namespace App\Http\Resources\Users;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin User */

class UsersResource extends JsonResource
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
            'name' => $this->name,
            'login' => $this->login,
            'roles' => $this->roles,
            'string_role' => $this->string_role,
            'is_trainer' => $this->is_trainer,
            'is_super_user' => $this->is_super_user,
        ];
    }
}
