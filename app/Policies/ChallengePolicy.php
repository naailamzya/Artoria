<?php

namespace App\Policies;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChallengePolicy
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
    public function view(?User $user, Challenge $challenge): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->role !== 'curator') {
            return Response::deny('Only curators can create challenges.');
        }

        if (!$user->isActive()) {
            return Response::deny('Your curator account is pending approval.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Challenge $challenge): Response
    {
        return $user->id === $challenge->curator_id
            ? Response::allow()
            : Response::deny('You are not the curator of this challenge.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Challenge $challenge): Response
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }

        return $user->id === $challenge->curator_id
            ? Response::allow()
            : Response::deny('You are not the curator of this challenge.');
    }

    /**
     * Determine whether the user can submit to the challenge.
     */
    public function submit(User $user, Challenge $challenge): Response
    {
        if (!in_array($user->role, ['member', 'curator'])) {
            return Response::deny('Only members can submit to challenges.');
        }

        if (!$user->isActive()) {
            return Response::deny('Your account is not active.');
        }

        if (!$challenge->canAcceptSubmissions()) {
            return Response::deny('This challenge is not accepting submissions.');
        }

        if ($challenge->userHasEntered($user)) {
            return Response::deny('You have already submitted to this challenge.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can select winners.
     */
    public function selectWinner(User $user, Challenge $challenge): Response
    {
        if ($user->id !== $challenge->curator_id) {
            return Response::deny('Only the challenge curator can select winners.');
        }

        if (!$challenge->hasEnded()) {
            return Response::deny('Challenge must end before selecting winners.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Challenge $challenge): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Challenge $challenge): bool
    {
        return $user->isAdmin();
    }
}