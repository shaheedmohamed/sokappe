<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OPayService;
use Illuminate\Support\Facades\Http;

class TestOPayConnection extends Command
{
    protected $signature = 'opay:test';
    protected $description = 'Test OPay API connection and functionality';

    public function handle()
    {
        $this->info('🚀 Testing OPay Connection...');
        
        // Test basic configuration
        if (!$this->testConfiguration()) {
            return 1;
        }
        
        // Test supported banks
        $this->testSupportedBanks();
        
        // Test payment link creation (mock)
        $this->testPaymentLink();
        
        $this->info('✅ OPay connection test completed!');
        return 0;
    }
    
    private function testConfiguration()
    {
        $this->info('🔧 Testing: Configuration');
        
        $baseUrl = config('services.opay.base_url');
        $merchantId = config('services.opay.merchant_id');
        $publicKey = config('services.opay.public_key');
        $secretKey = config('services.opay.secret_key');
        $environment = config('services.opay.environment', 'sandbox');
        
        if (empty($baseUrl) || empty($merchantId) || empty($publicKey) || empty($secretKey)) {
            $this->error('❌ OPay configuration is incomplete!');
            $this->line('Please check your .env file for:');
            $this->line('- OPAY_BASE_URL');
            $this->line('- OPAY_MERCHANT_ID');
            $this->line('- OPAY_PUBLIC_KEY');
            $this->line('- OPAY_SECRET_KEY');
            return false;
        }
        
        $this->info('✅ Configuration looks good');
        $this->line("🌐 Base URL: {$baseUrl}");
        $this->line("🏪 Merchant ID: {$merchantId}");
        $this->line("🔑 Public Key: " . substr($publicKey, 0, 20) . '...');
        $this->line("🛠️  Environment: {$environment}");
        
        return true;
    }
    
    private function testSupportedBanks()
    {
        $this->info('🏦 Testing: Get Supported Banks');
        
        try {
            $opayService = new OPayService();
            $result = $opayService->getSupportedBanks('EG');
            
            if ($result['success']) {
                $this->info('✅ Banks API: Success');
                $banksCount = count($result['banks']);
                $this->line("📊 Banks count: {$banksCount}");
                
                if (!empty($result['banks'])) {
                    $this->line('🏦 Sample banks:');
                    foreach (array_slice($result['banks'], 0, 5) as $bank) {
                        $bankName = $bank['bankName'] ?? $bank['name'] ?? 'Unknown';
                        $bankCode = $bank['bankCode'] ?? $bank['code'] ?? 'N/A';
                        $this->line("   • {$bankName} ({$bankCode})");
                    }
                }
            } else {
                $this->error('❌ Banks API: Failed');
                $this->line('💬 Message: ' . $result['message']);
            }
        } catch (\Exception $e) {
            $this->error('❌ Banks API: Exception');
            $this->line('🚨 Error: ' . $e->getMessage());
        }
    }
    
    private function testPaymentLink()
    {
        $this->info('💳 Testing: Payment Link Structure');
        
        try {
            $baseUrl = config('services.opay.base_url');
            $merchantId = config('services.opay.merchant_id');
            $secretKey = config('services.opay.secret_key');
            
            // Test payload structure
            $testPayload = [
                'reference' => 'TEST_' . time(),
                'amount' => 1000, // $10.00 in cents
                'currency' => 'EGP',
                'callbackUrl' => 'https://example.com/callback',
                'returnUrl' => 'https://example.com/return',
                'cancelUrl' => 'https://example.com/cancel',
                'userInfo' => [
                    'userId' => '1',
                    'userEmail' => 'test@example.com',
                    'userName' => 'Test User',
                    'userMobile' => '+201234567890',
                ],
                'productName' => 'Wallet Top-up',
                'productDesc' => 'Test wallet recharge',
                'expireAt' => now()->addMinutes(30)->timestamp,
                'country' => 'EG',
            ];
            
            $headers = [
                'Authorization' => 'Bearer ' . $secretKey,
                'MerchantId' => $merchantId,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];
            
            $endpoint = '/api/v3/cashier/initialize';
            
            $this->line('📋 Test payload structure:');
            $this->line("   • Reference: {$testPayload['reference']}");
            $this->line("   • Amount: {$testPayload['amount']} cents ({$testPayload['currency']})");
            $this->line("   • Endpoint: {$endpoint}");
            $this->line("   • Headers: Authorization, MerchantId, Content-Type, Accept");
            
            // Test the actual API call
            $this->line('🌐 Testing API call...');
            
            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->post($baseUrl . $endpoint, $testPayload);
                
            if ($response->successful()) {
                $data = $response->json();
                $this->info('✅ Payment Link API: HTTP Success');
                $this->line('📊 Response code: ' . ($data['code'] ?? 'N/A'));
                $this->line('💬 Response message: ' . ($data['message'] ?? 'N/A'));
                
                if (isset($data['data']['cashierUrl'])) {
                    $this->info('🎉 Payment URL generated successfully!');
                    $this->line('🔗 URL: ' . substr($data['data']['cashierUrl'], 0, 50) . '...');
                }
            } else {
                $this->error('❌ Payment Link API: HTTP Failed');
                $this->line('📊 Status: ' . $response->status());
                $this->line('💬 Response: ' . $response->body());
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Payment Link: Exception');
            $this->line('🚨 Error: ' . $e->getMessage());
        }
    }
}
