<?php

namespace App\Listeners;

use App\Models\User;

use Illuminate\Auth\Events\Logout;

class LogLogoutActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        $user = $event->user;
        $request = request();

        if ($user instanceof User) {
            activity('auth')
                ->causedBy($user)
                ->event('logout')
                ->withProperties([
                    "attributes" => [
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent()
                    ]
                ])
                ->log("User logged out");
        }
    }
}
