<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogout
{
    public function __construct()
    {
        //
    }

    public function handle(Logout $event)
    {
        if ($event->user) {
            ActivityLogger::log(
                $event->user->id,
                'logout',
                [
                    'logout_time' => now()->toDateTimeString()
                ]
            );
        }
    }
}
