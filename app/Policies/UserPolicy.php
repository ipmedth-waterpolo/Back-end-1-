<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // Determine if the current user can view the given user
    public function view(User $currentUser, User $user)
    {
        // Allow viewing if the user is an admin, onderhoud, or the user themselves
        return $currentUser->id === $user->id || 
               $currentUser->role === 'admin' || 
               $currentUser->role === 'onderhoud';
    }

    // Determine if the current user can update the given user
    public function update(User $currentUser, User $user)
    {
        // Allow updating if the user is an admin, onderhoud, or the user themselves
        return $currentUser->id === $user->id || 
               $currentUser->role === 'admin' || 
               $currentUser->role === 'onderhoud';
    }

    // Determine if the current user can delete the given user
    public function delete(User $currentUser, User $user)
    {
        // Allow deletion if the user is an admin, onderhoud, or the user themselves
        return $currentUser->id === $user->id || 
               $currentUser->role === 'admin' || 
               $currentUser->role === 'onderhoud';
    }
}
