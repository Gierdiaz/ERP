<?php

namespace App\Interfaces;

use App\DTO\CustomerDTO;
use App\Models\Customer;

interface CustomerInterface
{
    public function getAll();

    public function getById($id);

    public function create(CustomerDTO $customerDTO);

    public function update(Customer $customer, CustomerDTO $customerDTO);

    public function delete(Customer $customer);
}
