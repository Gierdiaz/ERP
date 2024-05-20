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
        // return $user->can('view customers');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create customers');
        // return $user->can('create customers');
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create customers');
        // return $user->can('update customers');
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('create customers');
        // return $user->can('delete customers');
    }
}
