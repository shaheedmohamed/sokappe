<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Wallet;

class CreateWalletsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:create-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create wallets for all users who don\'t have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating wallets for users...');
        
        $users = User::whereDoesntHave('wallet')->get();
        
        if ($users->isEmpty()) {
            $this->info('All users already have wallets!');
            return;
        }
        
        $created = 0;
        
        foreach ($users as $user) {
            try {
                Wallet::createForUser($user->id);
                $this->line("✅ Created wallet for: {$user->name} ({$user->email})");
                $created++;
            } catch (\Exception $e) {
                $this->error("❌ Failed to create wallet for {$user->name}: {$e->getMessage()}");
            }
        }
        
        $this->info("🎉 Successfully created {$created} wallets!");
    }
}
