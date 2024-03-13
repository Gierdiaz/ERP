<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\Email\EmailVerificationRequest;
use App\Notifications\Auth\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        //Log::channel('verification')->info('User email verified.', ['email' => $request->user()->email]);
        Log::channel('verification')->info('Email verification request received.', [
            'id' => $request->route('id'),
            'hash' => $request->route('hash'),
        ]);

        return response()->json(['message' => 'Email verified successfully.']);
    }

    public function resend(EmailVerificationRequest $request)
    {
        try {
            $user = $request->user();

            if ($user->hasVerifiedEmail()) {
                return response()->json(['message' => 'User has already verified email.'], 400);
            }

            $user->notify(new VerifyEmailNotification($user));

            Log::channel('verification')->info('Verification email resent.', ['email' => $user->email]);

            return response()->json(['message' => 'Verification email resent successfully.']);
        } catch (\Throwable $th) {
            Log::channel('verification')->error('Failed to resend verification email.', ['error' => $th->getMessage()]);

            return response()->json(['error' => 'Failed to resend verification email.'], 400);
        }
    }
}
