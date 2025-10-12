<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateUsernames extends Command
{
    protected $signature = 'users:generate-usernames';
    protected $description = 'Generate usernames for existing users';

    public function handle()
    {
        $users = User::whereNull('username')->get();
        
        if ($users->count() === 0) {
            $this->info('All users already have usernames.');
            return;
        }

        $this->info("Generating usernames for {$users->count()} users...");

        foreach ($users as $user) {
            $user->username = User::generateUsername($user->name);
            $user->save();
            $this->line("Generated username: {$user->username} for {$user->name}");
        }

        $this->info('Done!');
    }
}
