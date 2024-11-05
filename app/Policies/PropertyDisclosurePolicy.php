<?php

namespace App\Policies;

use App\Models\PropertyDisclosure;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyDisclosurePolicy
{
    use HandlesAuthorization;

    public function view(User $user, PropertyDisclosure $propertyDisclosure)
    {
        return $user->id === $propertyDisclosure->user_id;
    }

    public function update(User $user, PropertyDisclosure $propertyDisclosure)
    {
        return $user->id === $propertyDisclosure->user_id;
    }

    public function delete(User $user, PropertyDisclosure $propertyDisclosure)
    {
        return $user->id === $propertyDisclosure->user_id;
    }
}
