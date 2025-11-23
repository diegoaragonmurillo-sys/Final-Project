<?php

namespace App\Policies;

use App\Models\User;

class MotoPolicy
{
    public function before(User $user)
    {
        return $user->role === 'admin';
    }
}
