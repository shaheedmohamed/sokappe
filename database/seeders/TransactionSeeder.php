<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereHas('wallet')->get();
        
        foreach ($users as $user) {
            $wallet = $user->wallet;
            
            // إنشاء معاملات إيداع مختلفة
            $this->createTransaction($wallet, [
                'type' => 'deposit',
                'amount' => 500,
                'status' => 'completed',
                'payment_method' => 'opay',
                'description' => 'إيداع عبر OPay'
            ]);
            
            $this->createTransaction($wallet, [
                'type' => 'deposit',
                'amount' => 250,
                'status' => 'pending',
                'payment_method' => 'bank_transfer',
                'description' => 'إيداع عبر تحويل بنكي'
            ]);
            
            // إنشاء معاملات سحب
            if ($wallet->balance >= 100) {
                $this->createTransaction($wallet, [
                    'type' => 'withdrawal',
                    'amount' => 100,
                    'fee' => 2,
                    'status' => 'pending',
                    'payment_method' => 'opay',
                    'description' => 'طلب سحب عبر OPay',
                    'notes' => 'تفاصيل الحساب: +201234567890'
                ]);
            }
            
            // إنشاء معاملات عمولة
            $this->createTransaction($wallet, [
                'type' => 'commission',
                'amount' => 25,
                'status' => 'completed',
                'description' => 'عمولة من مشروع مكتمل'
            ]);
            
            // إنشاء معاملة مكافأة
            if (rand(1, 3) === 1) {
                $this->createTransaction($wallet, [
                    'type' => 'bonus',
                    'amount' => 50,
                    'status' => 'completed',
                    'description' => 'مكافأة ترحيب'
                ]);
            }
        }
        
        $this->command->info('تم إنشاء معاملات تجريبية بنجاح!');
    }
    
    private function createTransaction($wallet, $data)
    {
        $transaction = $wallet->transactions()->create([
            'user_id' => $wallet->user_id,
            'transaction_id' => 'TXN_' . time() . '_' . rand(1000, 9999),
            'type' => $data['type'],
            'amount' => $data['amount'],
            'fee' => $data['fee'] ?? 0,
            'net_amount' => $data['amount'] - ($data['fee'] ?? 0),
            'currency' => 'USD',
            'status' => $data['status'],
            'payment_method' => $data['payment_method'] ?? null,
            'description' => $data['description'],
            'notes' => $data['notes'] ?? null,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Test Browser)',
            'processed_at' => $data['status'] !== 'pending' ? now() : null,
            'completed_at' => $data['status'] === 'completed' ? now() : null,
        ]);
        
        // تحديث رصيد المحفظة للمعاملات المكتملة
        if ($data['status'] === 'completed') {
            if ($data['type'] === 'deposit' || $data['type'] === 'bonus' || $data['type'] === 'commission') {
                $wallet->increment('balance', $data['amount']);
                $wallet->increment('total_earned', $data['amount']);
            }
        }
        
        // تجميد الرصيد لطلبات السحب المعلقة
        if ($data['type'] === 'withdrawal' && $data['status'] === 'pending') {
            if ($wallet->balance >= $data['amount']) {
                $wallet->decrement('balance', $data['amount']);
                $wallet->increment('pending_balance', $data['amount']);
            }
        }
        
        $wallet->update(['last_transaction_at' => now()]);
        
        return $transaction;
    }
}
