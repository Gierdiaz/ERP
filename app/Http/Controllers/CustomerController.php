<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponse;
use App\Http\Requests\CustomerFormRequest;
use App\Http\Resources\CustomerResource;
use App\Interfaces\CustomerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{DB, Log};

class CustomerController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }
dsadsa
    public function index(): JsonResponse
    {
        try {

            $customers = $this->customerRepository->getAll();

            return ApiResponse::sendResponse(CustomerResource::collection($customers), '', 200);
        } catch (\Exception $e) {
            return ApiResponse::throw($e);
        }
    }

    public function show($id)
    {
        try {
            $customer = $this->customerRepository->getById($id);

            return CustomerResource::make($customer);
        } catch (\Exception $e) {
            return ApiResponse::throw($e);

        }
    }

    public function store(CustomerFormRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {

            $validated = $request->validated();

            $customer = $this->customerRepository->create($validated);

            DB::commit();

            Log::channel('customer')->info('Customer created successfully', ['customer_id' => $customer->id]);

            return ApiResponse::sendResponse(new CustomerResource($customer), __('Customer created successfully'), 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::channel('customer')->info('Failed to store customer: ' . $e->getMessage());

            return ApiResponse::rollback($e, __('Failed to store customer'));
        }
    }

    public function update(CustomerFormRequest $request, $id): JsonResponse
    {
        DB::beginTransaction();

        try {

            $validated = $request->validated();

            $customer = $this->customerRepository->getById($id);
            $customer->update($validated);

            DB::commit();

            Log::channel('customer')->info('Customer updated successfully', ['customer_id' => $customer->id]);

            return ApiResponse::sendResponse(new CustomerResource($customer), __('Customer updated successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::channel('customer')->info('Failed to update customer: ' . $e->getMessage());

            return ApiResponse::rollback($e, __('Failed to update customer'));
        }
    }

    public function destroy($id): JsonResponse
    {
        DB::beginTransaction();

        try {

            $customer = $this->customerRepository->getById($id);
            $this->customerRepository->delete($customer);

            DB::commit();

            Log::channel('customer')->info('Customer deleted successfully', ['customer_id' => $id]);

            return ApiResponse::sendResponse([], __('Customer deleted successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            return ApiResponse::rollback($e, __('Failed to delete customer'));
        }
    }
}
