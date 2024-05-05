<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerFormRequest;
use App\Http\Resources\CustomerResource;
use App\Interfaces\CustomerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{DB, Log};

class CustomerController extends Controller
{
    protected CustomerInterface $customerRepository;

    public function __construct(CustomerInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index(): JsonResponse
    {
        $customers = $this->customerRepository->getAll();

        return response()->json(['data' => CustomerResource::collection($customers)], 200);
    }

    public function show(string $id): JsonResponse
    {
        $customer = $this->customerRepository->getById($id);

        return response()->json(['data' => new CustomerResource($customer)], 200);
    }

    public function store(CustomerFormRequest $request): JsonResponse
    {
        DB::beginTransaction();

        $validated = $request->validated();

        try {
            $customer = $this->customerRepository->create($validated);
            DB::commit();
            Log::channel('customer')->info('Customer created successfully', ['customer_id' => $customer->id]);

            return response()->json(['data' => new CustomerResource($customer)], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('customer')->error('Failed to store customer: ' . $e->getMessage());

            return response()->json(['message' => __('Failed to store customer')], 500);
        }
    }

    public function update(CustomerFormRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        $validated = $request->validated();

        try {
            $customer = $this->customerRepository->getById($id);
            $customer->update($validated);
            DB::commit();
            Log::channel('customer')->info('Customer updated successfully', ['customer_id' => $customer->id]);

            return response()->json(['data' => new CustomerResource($customer)], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('customer')->error('Failed to update customer: ' . $e->getMessage());

            return response()->json(['message' => __('Failed to update customer')], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $customer = $this->customerRepository->getById($id);
            $this->customerRepository->delete($customer);
            DB::commit();
            Log::channel('customer')->info('Customer deleted successfully', ['customer_id' => $id]);

            return response()->json(['message' => __('Customer deleted successfully')], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('customer')->error('Failed to delete customer: ' . $e->getMessage());

            return response()->json(['message' => __('Failed to delete customer')], 500);
        }
    }
}
