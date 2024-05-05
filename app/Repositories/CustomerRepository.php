<?php

namespace App\Repositories;

use App\Interfaces\CustomerInterface;
use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerInterface
{
    protected Customer $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->model->orderBy('created_at', 'desc')->paginate(2);
    }

    public function getById(int $id): Customer
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array<mixed> $data
     * @return Customer
     */
    public function create(array $data): Customer
    {
        return $this->model->create($data);
    }

    /**
     * @param array<mixed> $data
     * @return Customer
     */
    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);

        return $customer;
    }

    /**
     * @param Customer $customer
     * @return bool|null
     */
    public function delete(Customer $customer): ?bool
    {
        return $customer->delete();
    }
}
