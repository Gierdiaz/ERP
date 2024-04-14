<?php

namespace App\Repositories;

use App\Interfaces\CustomerInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerInterface
{
    protected $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function getAll()
    {
        return $this->model->orderBy('created_at', 'desc')->paginate(2);
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Customer $customer, array $data)
    {
        $customer->update($data);

        return $customer;
    }

    public function delete(Customer $customer)
    {
        return $customer->delete();
    }
}
