<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerFormRequest;
use App\Http\Resources\CustomerResource;
use App\Interfaces\CustomerInterface;
use App\Models\{Customer, Permission, Role, User};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{DB, Log};

class CustomerController extends Controller
{
    use AuthorizesRequests;

    protected CustomerInterface $customerRepository;

    public function __construct(CustomerInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index(string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->authorize('view', Customer::class);

        $customers = $this->customerRepository->getAll($user);

        return response()->json(['data' => CustomerResource::collection($customers)], 200);
    }

    public function show(string $id): JsonResponse
    {
        $this->authorize('view', Customer::class);

        $customer = $this->customerRepository->getById($id);

        return response()->json(['data' => new CustomerResource($customer)], 200);
    }

    public function store(CustomerFormRequest $request): JsonResponse
    {
        $this->authorize('create', Customer::class);

        DB::beginTransaction();

        try {
            $customer = $this->customerRepository->create($request->validated());
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
        $this->authorize('update', Customer::class);

        DB::beginTransaction();

        try {
            $customer = $this->customerRepository->getById($id);
            $customer->update($request->validated());
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
        $this->authorize('delete', Customer::class);

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
