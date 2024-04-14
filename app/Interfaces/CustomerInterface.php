<?php

namespace App\Interfaces;

use App\Models\Customer;

interface CustomerInterface
{
    public function getAll();

    public function getById($id);

    public function create(array $data);

    public function update(Customer $customer, array $data);

    public function delete(Customer $customer);
}
