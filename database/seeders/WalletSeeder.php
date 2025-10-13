<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add some demo balance to freelancers
        $freelancers = User::where('role', 'freelancer')->get();
        
        foreach ($freelancers as $freelancer) {
            $wallet = $freelancer->wallet;
            
            if ($wallet) {
                // Add some demo transactions
                $amounts = [500, 750, 1200, 300, 900];
                
                foreach ($amounts as $amount) {
                    $wallet->addBalance($amount, 'رصيد تجريبي - مكافأة ترحيب');
                }
                
                $this->command->info("Added demo balance to {$freelancer->name}: {$wallet->fresh()->balance} EGP");
            }
        }
        
        // Add some balance to employers too
        $employers = User::where('role', 'employer')->get();
        
        foreach ($employers as $employer) {
            $wallet = $employer->wallet;
            
            if ($wallet) {
                $wallet->addBalance(2000, 'رصيد تجريبي - مكافأة ترحيب للعملاء');
                $this->command->info("Added demo balance to {$employer->name}: {$wallet->fresh()->balance} EGP");
            }
        }
    }
}
