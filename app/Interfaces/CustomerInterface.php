<?php

namespace App\Interfaces;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CustomerInterface
{
    public function getAll(): LengthAwarePaginator;

    public function getById(int $id): Customer;

    /**
     * @param array<mixed> $data
     * @return Customer
     */
    public function create(array $data): Customer;

    /**
     * @param array<mixed> $data
     * @return Customer
     */
    public function update(Customer $customer, array $data): Customer;

    /**
     * @param Customer $customer
     * @return bool|null
     */
    public function delete(Customer $customer): ?bool;
}
