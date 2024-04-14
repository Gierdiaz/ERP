<?php

use App\Models\{Product, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{deleteJson,getJson ,postJson, putJson};

uses(RefreshDatabase::class);

describe('when the user is not auth', function () {
    it('should send unauthorized status after trying to retrieve products list', function () {
        getJson(route('products.index'))
          ->assertUnauthorized()
          ->assertJsonFragment(['message' => "Unauthenticated."]);
    });
});

describe('when the user is auth', function () {
    beforeEach(function () {
        Sanctum::actingAs(User::factory()->create());
    });

    it('should retrieve a list of products', function () {
        Product::factory(3)->create();

        getJson(route('products.index'))
          ->assertStatus(200)
          ->assertJsonCount(3, 'data');
    });

    it('should store new product', function () {
        $product = product::factory()->make()->toArray();

        postJson(route('products.store'), $product)
          ->assertStatus(201)
          ->assertJson([
              'success' => true,
              'message' => __('Product created successfully'),
          ]);
    });

    it('should update an existing product', function () {
        $product     = Product::factory()->create();
        $updatedData = Product::factory()->make()->toArray();

        putJson(route('products.update', $product->id), $updatedData)
          ->assertStatus(200)
          ->assertJson([
              'success' => true,
              'message' => __('Product updated successfully'),
          ]);
    });

    it('should delete a product', function () {
        $product = Product::factory()->create();

        deleteJson(route('products.destroy', $product->id))
          ->assertStatus(200)
          ->assertJson([
              'success' => true,
              'message' => __('Product deleted successfully'),
          ]);
    });
});
