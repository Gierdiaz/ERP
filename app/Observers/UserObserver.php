<?php

namespace App\Observers;

use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        dispatch(new SendWelcomeEmailJob($user))->delay(now()->addMinutes(1));
    }
}
