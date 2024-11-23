<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Auth;

class ValidateUserLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Attempting  $event
     * @return void
     */
    public function handle(Attempting $event)
    {
        $user = \App\Models\User::where('email', $event->credentials['email'])->first();

        if ($user && ($user->is_deleted == 1 || $user->status == 0)) {
            Auth::logout();
            abort(403, 'Acceso denegado: el usuario está inactivo o eliminado.');
        }
    }
}
