<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    public function delete(?User $user): bool
    {
        return $user?->role === UserRole::ADMIN;
    }
}
