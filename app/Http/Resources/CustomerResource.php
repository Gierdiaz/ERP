<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property int $user_id
 * @property string $created_at
 */
class CustomerResource extends JsonResource
{
    public int $id;

    public string $name;

    public string $email;

    public string $phone;

    public string $address;

    public int $user_id;

    public string $created_at;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->id         = $resource->id;
        $this->name       = $resource->name;
        $this->email      = $resource->email;
        $this->phone      = $resource->phone;
        $this->address    = $resource->address;
        $this->user_id    = $resource->user_id;
        $this->created_at = $resource->created_at;
    }

    public function toArray(Request $request): array
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
