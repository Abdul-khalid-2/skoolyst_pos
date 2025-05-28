<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Purchase;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Purchase $purchase)
    {
        return $user->tenant_id == $purchase->tenant_id;
    }

    public function create(User $user)
    {
        return $user->can('create purchases');
    }

    public function update(User $user, Purchase $purchase)
    {
        return $user->tenant_id == $purchase->tenant_id 
            && $user->can('edit purchases')
            && $purchase->status != 'cancelled';
    }

    public function delete(User $user, Purchase $purchase)
    {
        return $user->tenant_id == $purchase->tenant_id 
            && $user->can('delete purchases')
            && $purchase->status == 'cancelled';
    }
}