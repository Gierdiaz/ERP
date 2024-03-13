<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Validator};

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        // Validation of input data
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:3'],
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json(['Errors' => $validator->errors()], 422);
        }

        try {
            // User creation
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // If user creation fails, throw an exception
            if (!$user) {
                throw new \Exception('Error creating user');
            }

            // Return a success response with the created user
            return response()->json([
                'message' => 'User registered successfully',
                'user'    => $user,
            ], 201);

        } catch (\Throwable $th) {
            // Return an error response if an exception occurs
            return response()->json([
                'error' => 'Failed to register user',
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // Validation of input data
        $validator = Validator::make($request->all(), [
            'email'       => ['required', 'email'],
            'password'    => ['required', 'string'],
            'device_name' => ['required', 'string'],
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get credentials from the request
        $credentials = $request->only('email', 'password');

        // Check if the user exists and the credentials are correct
        if (!Auth::attempt($credentials)) {
            // Invalid credentials
            logger('Invalid credentials for email: ' . $request->email);

            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Generate the Sanctum token
        $token = $user->createToken($request->device_name)->plainTextToken;

        // Return the success response
        return response()->json([
            'Message'  => 'Login successful',
            'Customer' => $user,
            'Token'    => $token,
        ], 200);
    }
}
