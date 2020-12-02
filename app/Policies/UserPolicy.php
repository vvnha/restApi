<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function view(User $user, User $positionID)
    {
        return $user->positionID == $positionID;
    }
    public function viewMe(User $user, User $userID)
    {
        return $user->id == $userID;
    }
    public function create(User $user)
    {
        return $user->id > 0;
    }
    
    public function update(User $user, User $userID)
    {
        return $user->id >0;
    }
    
    public function delete(User $user, User $positionID)
    {
        return $user->positionID == $positionID;
    }
}
