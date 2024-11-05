<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContactInquiry;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactInquiryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ContactInquiry $contactInquiry)
    {
        return $user->id === $contactInquiry->user_id
            || $user->isAdmin()
            || ($user->isAgent() && $user->id === $contactInquiry->assigned_to);
    }

    public function update(User $user, ContactInquiry $contactInquiry)
    {
        return $user->id === $contactInquiry->user_id
            || $user->isAdmin()
            || ($user->isAgent() && $user->id === $contactInquiry->assigned_to);
    }

    public function delete(User $user, ContactInquiry $contactInquiry)
    {
        return $user->isAdmin();
    }
}
