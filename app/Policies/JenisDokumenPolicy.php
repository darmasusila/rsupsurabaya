<?php

namespace App\Policies;

use App\Models\JenisDokumen;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JenisDokumenPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->name === 'admin') {
            return true;
        }
        return $user->can('view_any_pegawai');
    }
}
