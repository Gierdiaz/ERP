<?php

namespace App\Policies;

use App\Models\{Customer, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('view customers');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create customers');;
        //return $user->role === 'admin';
        //return $user->hasRole('admin');
        //return $user->hasPermissionTo('create customers');
        //return $user->can('create customers');
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
