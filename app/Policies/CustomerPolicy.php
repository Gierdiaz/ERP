<?php

namespace App\Policies;

use App\Models\{Customer, User};

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage customers');
    }

    public function view(User $user, Customer $customer)
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

}
