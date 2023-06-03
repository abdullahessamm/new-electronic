<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        // Delete tokens if abilities or password changed.
        if (! ($user->getOriginal('abilities') == $user->abilities) || ! ($user->getOriginal('password') == $user->password))
            $user->tokens()->delete();
    }
}
