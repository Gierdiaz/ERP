<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $address
 * @property mixed $user_id
 * @property mixed $created_at
 */

class CustomerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'user_id'    => $this->user_id,
            'created_at' => $this->created_at,
        ];
    }
}
