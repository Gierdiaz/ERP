<?php

namespace App\Http\Controllers;

use App\Models\{Permission, Role, User};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $user->assignRole($adminRole);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    public function someMethod(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return response()->json(['message' => 'Usuário é admin']);
        } else {
            return response()->json(['message' => 'Usuário não é admin']);
        }
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $role = Role::where('name', $request->role)->first();
        $user->assignRole($role);

        return response()->json($user);
    }

    public function removeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $role = Role::where('name', $request->role)->first();
        $user->removeRole($role);

        return response()->json($user);
    }

    public function assignAccess(Request $request, User $user): JsonResponse
    {
        $this->authorize('assignAccess', User::class);

        $request->validate([
            'permissions'   => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        try {
            $permissions = collect($request->permissions)->map(function ($permission) {
                return Permission::findByName($permission);
            });

            $user->givePermissionTo($permissions->all());

            return response()->json(['message' => 'Access granted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to grant access: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to grant access.'], 500);
        }
    }

    public function revokeAccess(Request $request, User $user): JsonResponse
    {
        $this->authorize('revokeAccess', User::class);

        $request->validate([
            'permissions'   => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        try {
            $permissions = collect($request->permissions)->map(function ($permission) {
                return Permission::findByName($permission);
            });

            $user->revokePermissionTo($permissions->all());

            return response()->json(['message' => 'Access revoked successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to revoke access: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to revoke access.'], 500);
        }
    }

    public function revokeAllAccess(User $user): JsonResponse
    {
        $this->authorize('revokeAllAccess', User::class);

        try {
            $user->permissions()->detach();

            $restrictedRole = Role::where('name', 'restricted')->first();

            if ($restrictedRole) {
                $user->syncRoles([$restrictedRole]);
            }

            return response()->json(['message' => 'All access revoked and user restricted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to revoke all access: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to revoke all access.'], 500);
        }
    }

}
