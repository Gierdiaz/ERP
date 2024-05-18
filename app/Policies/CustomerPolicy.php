<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return $user->can('view customers');
    }

    public function create(User $user): bool
    {
        Log::info('Checking if user can create customers', ['user_id' => $user->id]);
        return $user->can('create customers');
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->can('update customers');
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->can('delete customers');
    }

    public function assignAccess(User $user): bool
    {
        return $user->can('assign_access_customer');
    }

    public function revokeAccess(User $user): bool
    {
        return $user->can('revoke_access_customer');
    }

    public function revokeAllAccess(User $user): bool
    {
        return $user->can('revoke_all_access_customer');
    }
}
