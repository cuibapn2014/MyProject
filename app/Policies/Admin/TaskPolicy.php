<?php

namespace App\Policies\Admin;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
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
     * Method update task
     *
     * @return bool
     */
    public function update(User $user, Task $task)
    {
        return $user->id === $task->id_nguoi_giao;
    }
}
