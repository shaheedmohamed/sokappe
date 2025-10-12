<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserRegistered
{
    public function __construct()
    {
        //
    }

    public function handle(Registered $event)
    {
        ActivityLogger::log(
            $event->user->id,
            'register',
            [
                'registration_time' => now()->toDateTimeString(),
                'user_role' => $event->user->role ?? 'user'
            ]
        );
    }
}
