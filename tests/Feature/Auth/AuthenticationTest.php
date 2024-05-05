<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('registers a new user', function () {
    $userData = [
        'name'                  => 'Allison',
        'email'                 => 'gierdiaz@hotmail.com',
        'language'              => 'en',
        'password'              => 'Gier3373@',
        'password_confirmation' => 'Gier3373@',
    ];

    postJson(route('register'), $userData)
        ->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email',
                'language',
            ],
        ]);
});

it('logs in an existing user', function () {
    $user = User::factory()->create([
        'email'    => 'gierdiaz@hotmail.com',
        'password' => Hash::make('Gier3373@'),
    ]);

    $loginData = [
        'email'       => 'gierdiaz@hotmail.com',
        'password'    => 'Gier3373@',
        'device_name' => 'Rapidapi',
    ];

    postJson(route('login'), $loginData)
        ->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'customer' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ],
            'token',
        ]);
});

it('fails login with incorrect credentials', function () {
    $loginData = [
        'email'       => 'wrong@example.com',
        'password'    => 'incorrectpassword',
        'device_name' => 'Rapidapi',
    ];

    postJson(route('login'), $loginData)
        ->assertStatus(401)
        ->assertJson([
            'error' => 'The provided credentials are incorrect.',
        ]);
});
