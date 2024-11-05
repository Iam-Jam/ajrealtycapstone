<?php

namespace App\Policies;

use App\Models\PurchaseAgreement;
use App\Models\User;

class PurchaseAgreementPolicy
{
    public function viewAny(User $user)
    {
        return $user->user_type === 'buyer' || $user->user_type === 'admin';
    }

    public function view(User $user, PurchaseAgreement $purchaseAgreement)
    {
        return $user->id === $purchaseAgreement->user_id || $user->user_type === 'admin';
    }

    public function create(User $user)
    {
        return $user->user_type === 'buyer';
    }

    public function update(User $user, PurchaseAgreement $purchaseAgreement)
    {
        return $user->id === $purchaseAgreement->user_id || $user->user_type === 'admin';
    }

    public function delete(User $user, PurchaseAgreement $purchaseAgreement)
    {
        return $user->id === $purchaseAgreement->user_id || $user->user_type === 'admin';
    }
}
