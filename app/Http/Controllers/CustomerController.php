<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::query()->orderBy('created_at', 'desc')->paginate();

        return CustomerResource::collection($customer);
    }
}
