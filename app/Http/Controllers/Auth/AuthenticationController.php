<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginFormRequest, RegisterFormRequest};
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\Auth\VerifyEmailNotification;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{App, Auth, Hash, Log};

class AuthenticationController extends Controller
{
    public function register(RegisterFormRequest $request): JsonResponse
    {
        try {
            $request->validated();

            $user = User::create([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'language' => $request->input('language'),
                'password' => Hash::make($request->input('password')),
            ]);

            if (!$user) {
                throw new \Exception(__('Error creating user'));
            }

            $user->assignRole('regular');

            $user->notify(new VerifyEmailNotification($user));

            Log::channel('register')->info('New user registered.', ['email' => $request->input('email')]);

            $language = $request->input('language');

            if (is_string($language)) {
                App::setLocale($language);
            } else {
                throw new \Exception(__('Invalid language format'));
            }

            return response()->json([
                'message' => __('User registered successfully.'),
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
                    'error' => 'The provided credentials are incorrect.',
                ], 401);
            }

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'User not found.',
                ], 404);
            }

            // Gerando o token de acesso usando o Laravel Passport
            $token = $user->createToken('TokenName')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user'    => new UserResource($user),
                'token'   => $token,
            ], 200);

        } catch (\Exception $e) {
            Log::channel('login')->error('Failed to login.', ['error' => $e->getMessage(), 'ip' => $request->ip()]);

            return response()->json([
                'error' => 'Failed to login. Please try again later.',
            ], 500);
        }
    }

    // Método para fazer logout usando o Laravel Passport
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
