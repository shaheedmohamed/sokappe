<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OPayService;
use App\Models\User;
use App\Models\Transaction;

class TestOPayConnection extends Command
{
    protected $signature = 'opay:test';
    protected $description = 'Test OPay API connection and functionality';

    public function handle()
    {
        $this->info('🧪 Testing OPay Connection...');
        
        try {
            $opayService = new OPayService();
            
            // Test 1: Get supported banks
            $this->info('📋 Testing: Get Supported Banks');
            $banksResult = $opayService->getSupportedBanks('EG');
            
            if ($banksResult['success']) {
                $this->info('✅ Banks API: Working');
                $this->line('   Found ' . count($banksResult['banks']) . ' banks');
            } else {
                $this->error('❌ Banks API: Failed - ' . $banksResult['message']);
            }
            
            // Test 2: Create a test transaction
            $this->info('💳 Testing: Create Payment Link');
            
            $user = User::first();
            if (!$user) {
                $this->error('❌ No users found. Please create a user first.');
                return;
            }
            
            $wallet = $user->wallet ?? \App\Models\Wallet::createForUser($user->id);
            
            $transaction = $wallet->transactions()->create([
                'user_id' => $user->id,
                'transaction_id' => 'TEST_' . time() . '_' . rand(1000, 9999),
                'type' => 'deposit',
                'amount' => 100,
                'fee' => 0,
                'net_amount' => 100,
                'currency' => 'USD',
                'status' => 'pending',
                'payment_method' => 'opay',
                'description' => 'Test payment via OPay',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Test Command',
            ]);
            
            $paymentResult = $opayService->createPaymentLink($transaction);
            
            if ($paymentResult['success']) {
                $this->info('✅ Payment Link: Created successfully');
                $this->line('   Reference: ' . $paymentResult['reference']);
                $this->line('   Payment URL: ' . $paymentResult['payment_url']);
            } else {
                $this->error('❌ Payment Link: Failed - ' . $paymentResult['message']);
            }
            
            // Test 3: Verify transaction status
            if (isset($paymentResult['reference'])) {
                $this->info('🔍 Testing: Verify Transaction');
                $verifyResult = $opayService->verifyTransaction($paymentResult['reference']);
                
                if ($verifyResult['success']) {
                    $this->info('✅ Verification: Working');
                    $this->line('   Status: ' . $verifyResult['status']);
                } else {
                    $this->error('❌ Verification: Failed - ' . $verifyResult['message']);
                }
            }
            
            // Clean up test transaction
            $transaction->delete();
            
            $this->info('🎉 OPay connection test completed!');
            
        } catch (\Exception $e) {
            $this->error('💥 Test failed with exception: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}
