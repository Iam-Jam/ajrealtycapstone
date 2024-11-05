<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Property;
use App\Models\ListProperty;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    /**
     * Allow anyone to view the list of properties
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Allow anyone to view a single property, including list/sell properties
     */
    public function view(?User $user, Property $property)
    {
        // If it's a ListProperty that's been transformed
        if (isset($property->list_property_id)) {
            $listProperty = ListProperty::find($property->list_property_id);
            return $listProperty && $listProperty->status === 'approved';
        }

        return true;
    }

    /**
     * Determine who can create properties
     */
    public function create(User $user)
    {
        return $user->isAdmin() || in_array($user->user_type, ['seller', 'lister', 'agent1', 'agent2']);
    }

    /**
     * Determine who can update properties
     */
    public function update(User $user, Property $property)
    {
        if ($user->isAdmin()) {
            return true;
        }

        // If it's a ListProperty that's been transformed
        if (isset($property->list_property_id)) {
            $listProperty = ListProperty::find($property->list_property_id);
            return $listProperty &&
                   $listProperty->user_id === $user->id &&
                   in_array($user->user_type, ['seller', 'lister', 'agent1', 'agent2']);
        }

        return $property->source === $user->user_type &&
               in_array($user->user_type, ['seller', 'lister']);
    }

    /**
     * Determine who can delete properties
     */
    public function delete(User $user, Property $property)
    {
        if ($user->isAdmin()) {
            return true;
        }

        // If it's a ListProperty that's been transformed
        if (isset($property->list_property_id)) {
            $listProperty = ListProperty::find($property->list_property_id);
            return $listProperty &&
                   $listProperty->user_id === $user->id &&
                   in_array($user->user_type, ['seller', 'lister', 'agent1', 'agent2']);
        }

        return $property->source === $user->user_type &&
               in_array($user->user_type, ['seller', 'lister']);
    }

    /**
     * Determine who can list properties
     */
    public function listProperty(User $user)
    {
        return in_array($user->user_type, ['seller', 'lister', 'agent1', 'agent2']);
    }

    /**
     * Determine who can sell properties
     */
    public function sellProperty(User $user)
    {
        return in_array($user->user_type, ['seller', 'agent1', 'agent2']);
    }

    /**
     * Determine if user can mark properties as featured/exclusive
     */
    public function toggleFeaturedExclusive(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can approve properties
     */
    public function approveProperty(User $user)
    {
        return $user->isAdmin();
    }
}
