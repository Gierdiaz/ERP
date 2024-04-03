<?php

namespace App\Repositories;

use App\DTO\CustomerDTO;
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
        return $this->model->orderBy('created_at', 'desc')->paginate();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(CustomerDTO $customerDTO)
    {
        return $this->model->create((array)$customerDTO);
    }

    public function update(Customer $customer, CustomerDTO $customerDTO)
    {
        $customer->update([
            'name'    => $customerDTO->name,
            'email'   => $customerDTO->email,
            'phone'   => $customerDTO->phone,
            'address' => $customerDTO->address,
            'user_id' => $customerDTO->user_id,
        ]);

        return $customer;
    }

    public function delete(Customer $customer)
    {
        return $customer->delete();
    }
}
