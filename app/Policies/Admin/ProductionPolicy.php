<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Method update production amount complete
     *
     * @return bool
     */
    public function update(User $user)
    {
        return (int) $user->role->department->id === 4 || $user->role->alias == 'USER_MANAGER';
    }
}
