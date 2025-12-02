<?php

namespace App\Policies;

use App\Models\Artwork;
use App\Models\User;
use illuminate\Auth\Access\Response;

class ArtworkPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Artwork $artwork): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        \Log::info('ArtworkPolicy create check', [
            'user_id' => $user->id,
            'role' => $user->role,
            'status' => $user->getStatusSafe(), 
            'isActive' => $user->isActive(),
        ]);
        
         return in_array($user->role, ['member', 'curator', 'admin']) 
           && $user->isActive();
    }

    public function update(User $user, Artwork $artwork): bool
    {
        return $user->id === $artwork->user_id;
    }

    public function delete(User $user, Artwork $artwork): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $artwork->user_id;
    }

    public function restore(User $user, Artwork $artwork): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Artwork $artwork): bool
    {
        return $user->isAdmin();
    }
    
    public function interact(User $user): bool
    {
        return in_array($user->role, ['member', 'curator']);
    }
    
    public function report(User $user, Artwork $artwork): bool
    {
        return $user->id !== $artwork->user_id;
    }
}