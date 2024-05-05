<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginFormRequest, RegisterFormRequest};
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\Auth\VerifyEmailNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{Auth, Hash, Log}; // Adicionando a importação da classe VerifyEmailNotification

class AuthenticationController extends Controller
{
    public function register(RegisterFormRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $photo = null;

            if ($request->hasFile('photo') && $request->file('photo') instanceof \Illuminate\Http\UploadedFile) {
                $photo = $request->file('photo')->store('user-photo', 'public');
            } else {
                // Your logic for generating a default photo
            }

            /** @var User $user */
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'photo'    => $photo,
                'language' => $validated['language'] ?? 'en',
                'password' => $validated['password'] ? Hash::make($validated['password']) : null,
                'type'     => 'admin',
            ]);

            if (!$user) {
                throw new \Exception(__('Error creating user'));
            }

            $user->notify(new VerifyEmailNotification($user, $photo));

            Log::channel('register')->info('New user registered.', ['email' => $validated['email']]);

            return response()->json([
                'message' => __('User registered successfully. Verification email sent to ') . $validated['email'],
                'user'    => new UserResource($user),
            ], 201);
        } catch (\Throwable $th) {
            Log::channel('register')->error('Failed to register user.', ['error' => $th->getMessage()]);

            return response()->json(['error' => __('Failed to register user')], 500);
        }
    }

    public function login(LoginFormRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                Log::channel('login')->debug('Failed login attempt.', ['email' => $request->email, 'ip' => $request->ip()]);

                return response()->json([
                    'message' => 'The provided credentials are incorrect.',
                ], 401);
            }

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found.',
                ], 404);
            }

            $token = $user->createToken($request->device_name ?? '')->plainTextToken;

            return response()->json([
                'message'  => 'Login successful',
                'customer' => $user,
                'token'    => $token,
            ], 200);

        } catch (\Exception $e) {
            Log::channel('login')->error('Failed to login.', ['error' => $e->getMessage(), 'ip' => $request->ip()]);

            return response()->json([
                'error' => 'Failed to login. Please try again later.',
            ], 500);
        }
    }
}
