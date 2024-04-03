<?php

namespace App\DTO;

class CustomerDTO
{
    public $name;

    public $email;

    public $phone;

    public $address;

    public $user_id;

    public function __construct($name, $email, $phone, $address, $user_id)
    {
        $this->name    = $name;
        $this->email   = $email;
        $this->phone   = $phone;
        $this->address = $address;
        $this->user_id = $user_id;
    }
}
