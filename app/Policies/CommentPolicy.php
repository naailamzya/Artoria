<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
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
    public function view(?User $user, Comment $comment): bool
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
    public function update(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny('You can only edit your own comments.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): Response
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }

        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny('You can only delete your own comments.');
    }

    /**
     * Determine whether the user can report the comment.
     */
    public function report(User $user, Comment $comment): bool
    {
        return $user->id !== $comment->user_id && $user->isActive();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }
}