<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginFormRequest, RegisterFormRequest};
use App\Models\User;
use App\Notifications\Auth\VerifyEmailNotification;
use Illuminate\Support\Facades\{Auth, Hash, Log};

class AuthenticationController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'language' => $request->language,
                'password' => Hash::make($request->password),

            ]);

            if (!$user) {
                throw new \Exception(__('Error creating user'));
            }

            $user->notify(new VerifyEmailNotification($user));

            Log::channel('register')->info('New user registered.', ['email' => $request->email]);

            App::setLocale($request->language);

            return response()->json([
                'message' => __('User registered successfully.  Verification email sent to ') . $user->email,
                'user'    => $user,
            ], 201);

        } catch (\Throwable $th) {
            Log::channel('register')->error('Failed to register user.', ['error' => $th->getMessage()]);

            return response()->json([
                'error' => __('Failed to register user'),
            ], 500);
        }
    }

    public function login(LoginFormRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                Log::channel('login')->debug('Failed login attempt.', ['email' => $request->email, 'ip' => $request->ip()]);

                return response()->json([
                    'message' => 'The provided credentials are incorrect.',
                ], 401);
            }

            $user  = Auth::user();
            $token = $user->createToken($request->device_name)->plainTextToken;

            return response()->json([
                'Message'  => 'Login successful',
                'Customer' => $user,
                'Token'    => $token,
            ], 200);

        } catch (\Exception $e) {
            Log::channel('login')->error('Failed to login.', ['error' => $e->getMessage(), 'ip' => $request->ip()]);

            return response()->json([
                'error' => 'Failed to login. Please try again later.',
            ], 500);
        }
    }
}
