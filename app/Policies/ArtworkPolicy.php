<?php

namespace App\Policies;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArtworkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Artwork $artwork): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['member', 'curator']) && $user->isActive();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Artwork $artwork): Response
    {
        return $user->id === $artwork->user_id
            ? Response::allow()
            : Response::deny('You do not own this artwork.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Artwork $artwork): Response
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }

        return $user->id === $artwork->user_id
            ? Response::allow()
            : Response::deny('You do not own this artwork.');
    }

    /**
     * Determine whether the user can interact with the artwork.
     */
    public function interact(User $user): bool
    {
        return in_array($user->role, ['member', 'curator']) && $user->isActive();
    }

    /**
     * Determine whether the user can report the artwork.
     */
    public function report(User $user, Artwork $artwork): bool
    {
        return $user->id !== $artwork->user_id && $user->isActive();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Artwork $artwork): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Artwork $artwork): bool
    {
        return $user->isAdmin();
    }
}