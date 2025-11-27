<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportPolicy
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
    public function view(User $user, Report $report): bool
    {
        return $user->isAdmin() || $user->id === $report->reporter_id;
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
    public function update(User $user, Report $report): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Report $report): Response
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }

        return $user->id === $report->reporter_id
            ? Response::allow()
            : Response::deny('You can only delete your own reports.');
    }

    /**
     * Determine whether the user can review the report.
     */
    public function review(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Report $report): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Report $report): bool
    {
        return $user->isAdmin();
    }
}