<?php

use App\Models\{Customer, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{deleteJson, getJson, postJson, putJson};

uses(RefreshDatabase::class);

beforeEach(function () {
    Sanctum::actingAs(User::factory()->create());
});

test('lists customers', function () {
    Customer::factory()->count(1)->create();

    getJson(route('customers.index'))
    ->assertStatus(200);
});

test('shows a specific customer', function () {
    $customer = Customer::factory()->create();

    getJson(route('customers.show', $customer->id))
    ->assertStatus(200)
    ->assertJson([
        'data' => [
            'id'      => $customer->id,
            'name'    => $customer->name,
            'email'   => $customer->email,
            'phone'   => $customer->phone,
            'address' => $customer->address,
        ],
    ]);
});

test('store a new customer', function () {
    $customerData = Customer::factory()->make()->toArray();

    postJson(route('customers.store'), $customerData)
    ->assertStatus(201)
    ->assertJsonStructure(['data' => [
        'id',
        'name',
        'email',
        'phone',
        'address',
    ]]);
});

test('updates an existing customer', function () {
    $customer    = Customer::factory()->create();
    $updatedData = Customer::factory()->make()->toArray();

    putJson(route('customers.update', $customer->id), $updatedData)
    ->assertStatus(200)
    ->assertJsonStructure(['data' => [
        'id',
        'name',
        'email',
        'phone',
        'address',
    ]]);
});

test('deletes a customer', function () {
    $customer = Customer::factory()->create();

    deleteJson(route('customers.destroy', $customer->id))
    ->assertStatus(200)
    ->assertJson([
        'message' => __('Customer deleted successfully'),
    ]);
});
