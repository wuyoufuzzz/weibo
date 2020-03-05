<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy 
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

    //
    // ! 更改用户
    public function update( User $user, User $currentUser ) 
    {
        return $user->id === $currentUser->id;
    }

    // ! 删除用户
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

}
