<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function assignAccess(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('assign_access_customer');
    }

    public function revokeAccess(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('revoke_access_customer');
    }

    public function revokeAllAccess(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('revoke_all_access_customer');
    }
}
