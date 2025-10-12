<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogin
{
    public function __construct()
    {
        //
    }

    public function handle(Login $event)
    {
        ActivityLogger::log(
            $event->user->id,
            'login',
            [
                'login_time' => now()->toDateTimeString(),
                'remember' => $event->remember ?? false
            ]
        );
    }
}
