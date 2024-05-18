<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $user
 */
class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Customer $this */
        return [
            'id'      => $this->id,
            'user'    => $this->user ? $this->user->name : null,
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'address' => $this->address,
        ];
    }
}
