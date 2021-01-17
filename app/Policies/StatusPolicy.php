<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Status  $status
     * @return mixed
     */
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
}
