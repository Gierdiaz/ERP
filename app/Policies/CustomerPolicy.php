<?php

namespace App\Policies;

use App\Models\{Customer, User};

class CustomerPolicy
{
    public function view(User $user, Customer $customer): bool
    {
        return $user->hasPermissionTo('view customers');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create customers');
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->hasPermissionTo('update customers');
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->hasPermissionTo('delete customers');
    }

    public function assignAccess(User $user, Customer $customer): bool
    {
        return $user->hasPermissionTo('assign_access_customer');
    }

    public function revokeAccess(User $user, Customer $customer): bool
    {
        return $user->hasPermissionTo('revoke_access_customer');
    }

    public function revokeAllAccess(User $user, Customer $customer): bool
    {
        return $user->hasPermissionTo('revoke_all_access_customer');
    }

}
