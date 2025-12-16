<?php

namespace App\Policies;

use App\Models\ShippingDocument;
use App\Models\User;

class ShippingDocumentPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShippingDocument $shippingDocument): bool
    {
        return $user->id === $shippingDocument->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShippingDocument $shippingDocument): bool
    {
        return $user->id === $shippingDocument->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShippingDocument $shippingDocument): bool
    {
        return $user->id === $shippingDocument->user_id;
    }
}
