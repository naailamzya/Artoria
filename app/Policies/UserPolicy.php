<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }

        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('You can only update your own profile.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        if (!$user->isAdmin()) {
            return Response::deny('Only admins can delete users.');
        }

        if ($user->id === $model->id) {
            return Response::deny('You cannot delete your own account.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can approve curator accounts.
     */
    public function approveCurator(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can manage user roles.
     */
    public function manageRoles(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can suspend/unsuspend users.
     */
    public function manageStatus(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }
}