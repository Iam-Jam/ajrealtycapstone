<?php

namespace App\Policies;

use App\Models\ListProperty;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListPropertyPolicy
{
    use HandlesAuthorization;

    /**
     * Check if user type is authorized to handle properties
     */
    private function isAuthorizedUserType(User $user)
    {
        return in_array($user->user_type, ['admin', 'agent1', 'agent2', 'seller']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ListProperty $listProperty)
    {
        // Check if user has an authorized type
        if (!$this->isAuthorizedUserType($user)) {
            return false;
        }

        // Admin can view all properties
        if ($user->user_type === 'admin') {
            return true;
        }

        // Agents can view all properties
        if (in_array($user->user_type, ['agent1', 'agent2'])) {
            return true;
        }

        // Sellers can view their own properties
        if ($user->user_type === 'seller') {
            return $user->id === $listProperty->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $this->isAuthorizedUserType($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ListProperty $listProperty)
    {
        if (!$this->isAuthorizedUserType($user)) {
            return false;
        }

        // Admin can update any property
        if ($user->user_type === 'admin') {
            return true;
        }

        // Property owner can update if they're an authorized user type
        return $user->id === $listProperty->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ListProperty $listProperty)
    {
        if (!$this->isAuthorizedUserType($user)) {
            return false;
        }

        // Admin can delete any property
        if ($user->user_type === 'admin') {
            return true;
        }

        // Property owner can delete if they're an authorized user type
        return $user->id === $listProperty->user_id;
    }
}
