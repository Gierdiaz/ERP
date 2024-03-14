<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerFormRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()->orderBy('created_at', 'desc')->paginate();

        return CustomerResource::collection($customers);
    }

    public function show(Customer $customer)
    {
        return CustomerResource::make($customer);
    }

    public function store(CustomerFormRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validate = $request->validated();

            $customer = Customer::create($validate);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => new CustomerResource($customer),
                'message' => __('Customer created successfully')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to store customer'], 500);
        }
    }

    public function update(CustomerFormRequest $request, Customer $customer): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validate = $request->validated();

            $customer->update($validate);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => new CustomerResource($customer),
                'message' => __('Customer updated successfully')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update customer'], 500);
        }
    }

    public function destroy(Customer $customer): JsonResponse
    {
        DB::beginTransaction();

        try {
            $customer->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('Customer deleted successfully')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete customer'], 500);
        }
    }
}
