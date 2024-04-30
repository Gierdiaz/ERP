<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginFormRequest};
use App\Models\User;
use App\Notifications\Auth\VerifyEmailNotification;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\{Auth, Hash, Log, Storage, Validator};

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'     => ['required', 'string'],
                'email'    => ['required', 'email'],
                'photo'    => ['nullable', 'image', 'max:2048'],
                'language' => ['nullable', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]+$/'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 404);
            }

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo')->store('user-photo', 'public');
            } else {
                $faker = Faker::create();
                $fakerAvatar = $faker->imageUrl(300, 300, 'people');
                $photo = 'avatars/' . uniqid() . '.jpg';
                Storage::disk('public')->put($photo, file_get_contents($fakerAvatar));
                
                if (!Storage::disk('public')->exists($photo)) {
                    throw new \Exception(__('Error saving avatar'));
                }
            }

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'photo'    => $photo,
                'language' => $request->language,
                'password' => Hash::make($request->password),
                'type'     => 'admin',
            ]);

            if (!$user) {
                throw new \Exception(__('Error creating user'));
            }

            $user->notify(new VerifyEmailNotification($user, $photo));

            Log::channel('register')->info('New user registered.', ['email' => $request->email]);

            App::setLocale($request->language);

            return response()->json([
                'message' => __('User registered successfully.  Verification email sent to ') . $user->email,
                'user'    => $user,
            ], 201);

        } catch (\Throwable $th) {
            Log::channel('register')->error('Failed to register user.', ['error' => $th->getMessage()]);

            return response()->json(['error' => __('Failed to register user')], 500);
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
