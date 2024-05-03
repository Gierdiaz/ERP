<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $id;

    public $name;

    public $email;

    public $photo;

    public $language;

    public $type;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->id       = $resource->id;
        $this->name     = $resource->name;
        $this->email    = $resource->email;
        $this->photo    = $resource->photo;
        $this->language = $resource->language;
        $this->type     = $resource->type;
    }

    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'photo'    => asset('storage/' . $this->photo),
            'language' => $this->language,
            'type'     => $this->type,
        ];
    }
}
