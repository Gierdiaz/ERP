<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string  $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string  $user_id
 * @property string $created_at
 */
class CustomerResource extends JsonResource
{
    public string $id;

    public string $name;

    public string $email;

    public string $phone;

    public string $address;

    public string $user_id;

    public string $created_at;

    public string $updated_at;

    public function __construct($resource)
    {
        parent::__construct($resource);

        if ($resource instanceof Customer) {
            $this->id         = (string) $resource->id;
            $this->name       = (string) $resource->name;
            $this->email      = (string) $resource->email;
            $this->phone      = (string) $resource->phone;
            $this->address    = (string) $resource->address;
            $this->user_id    = (string) $resource->user_id;
            $this->created_at = (string) $resource->created_at;
            $this->updated_at = (string) $resource->updated_at;
        }
    }

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
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'user_id'    => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
