<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public string $id;

    public string $name;

    public string $email;

    public string $photo;

    public string $language;

    public string $type;

    public function __construct($resource)
    {
        parent::__construct($resource);

        if ($resource instanceof User) {
            $this->id       = (string) $resource->id;
            $this->name     = (string) $resource->name;
            $this->email    = (string) $resource->email;
            $this->photo    = (string) $resource->photo;
            $this->language = (string) $resource->language;
            $this->type     = (string) $resource->type;
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
        /** @var User $this */
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'photo'    => $this->photo,
            'language' => $this->language,
            'type'     => $this->type,
        ];
    }
}
