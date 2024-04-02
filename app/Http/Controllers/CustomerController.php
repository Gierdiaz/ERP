<?php

namespace App\Http\Controllers;

use App\DTO\CustomerDTO;
use App\Http\Requests\CustomerFormRequest;
use App\Http\Resources\CustomerResource;
use App\Repositories\CustomerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customers = $this->customerRepository->getAll();

        return CustomerResource::collection($customers);
    }

    public function show($id)
    {
        $customer = $this->customerRepository->getById($id);

        return CustomerResource::make($customer);
    }

    public function store(CustomerFormRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $customerDTO = new CustomerDTO(
                $validated['name'],
                $validated['email'],
                $validated['phone'],
                $validated['address'],
                $validated['user_id']
            );

            $customer = $this->customerRepository->create($customerDTO);

            Log::channel('customer')->info('Customer created successfully', ['customer_id' => $customer->id]);

            return response()->json([
                'success' => true,
                'data'    => new CustomerResource($customer),
                'message' => __('Customer created successfully'),
            ], 201);

        } catch (\Exception $e) {
            Log::channel('customer')->error('Failed to store customer', ['exception' => $e]);

            return response()->json(['message' => 'Failed to store customer'], 500);
        }
    }

    public function update(CustomerFormRequest $request, $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            $customerDTO = new CustomerDTO(
                $validated['name'],
                $validated['email'],
                $validated['phone'],
                $validated['address'],
                $validated['user_id']
            );

            $customer = $this->customerRepository->getById($id);
            $customer = $this->customerRepository->update($customer, $customerDTO);

            Log::channel('customer')->info('Customer updated successfully', ['customer_id' => $customer->id]);

            return response()->json([
                'success' => true,
                'data'    => new CustomerResource($customer),
                'message' => __('Customer updated successfully'),
            ]);

        } catch (\Exception $e) {
            Log::channel('customer')->error('Failed to update customer', ['customer_id' => $id, 'exception' => $e]);

            return response()->json(['message' => 'Failed to update customer'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $customer = $this->customerRepository->getById($id);
            $this->customerRepository->delete($customer);

            Log::channel('customer')->info('Customer deleted successfully', ['customer_id' => $id]);

            return response()->json([
                'success' => true,
                'message' => __('Customer deleted successfully'),
            ]);

        } catch (\Exception $e) {
            Log::channel('customer')->error('Failed to delete customer', ['customer_id' => $id, 'exception' => $e]);

            return response()->json(['message' => 'Failed to delete customer'], 500);
        }
    }

}
