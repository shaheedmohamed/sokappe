<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;

class OPayService
{
    private $baseUrl;
    private $merchantId;
    private $secretKey;
    private $publicKey;

    public function __construct()
    {
        $this->baseUrl = config('services.opay.base_url', 'https://sandboxapi.opaycheckout.com');
        $this->merchantId = config('services.opay.merchant_id');
        $this->secretKey = config('services.opay.secret_key');
        $this->publicKey = config('services.opay.public_key');
    }

    /**
     * إنشاء رابط دفع للإيداع
     */
    public function createPaymentLink(Transaction $transaction, array $options = [])
    {
        try {
            $payload = [
                'reference' => $transaction->transaction_id,
                'amount' => (int)($transaction->amount * 100), // Convert to cents
                'currency' => $transaction->currency ?? 'USD',
                'callbackUrl' => route('opay.callback'),
                'returnUrl' => route('wallet.index'),
                'cancelUrl' => route('wallet.deposit'),
                'userInfo' => [
                    'userId' => (string)$transaction->user_id,
                    'userEmail' => $transaction->user->email,
                    'userName' => $transaction->user->name,
                    'userMobile' => $transaction->user->phone ?? '',
                ],
                'productName' => 'Wallet Top-up',
                'productDesc' => $transaction->description ?? 'Wallet recharge via OPay',
                'expireAt' => now()->addMinutes(30)->timestamp,
                'country' => 'EG',
            ];

            $headers = [
                'Authorization' => 'Bearer ' . $this->secretKey, // Use secret key for cashier
                'MerchantId' => $this->merchantId,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            // Use standard endpoint for all currencies in sandbox
            $endpoint = '/api/v3/cashier/initialize';
                
            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->post($this->baseUrl . $endpoint, $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['code'] === '00000') {
                    return [
                        'success' => true,
                        'payment_url' => $data['data']['cashierUrl'],
                        'reference' => $data['data']['reference'],
                        'order_no' => $data['data']['orderNo'],
                        'message' => 'Payment link created successfully'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $data['message'] ?? 'Failed to create payment link',
                        'error_code' => $data['code']
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'HTTP request failed: ' . $response->status(),
                    'response' => $response->body()
                ];
            }

        } catch (\Exception $e) {
            Log::error('OPay Payment Link Creation Failed', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Service temporarily unavailable: ' . $e->getMessage()
            ];
        }
    }

    /**
     * التحقق من حالة المعاملة
     */
    public function verifyTransaction($reference)
    {
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $this->publicKey,
                'MerchantId' => $this->merchantId,
            ];

            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->get($this->baseUrl . '/api/v3/cashier/status', [
                    'reference' => $reference,
                    'country' => 'EG' // or NG for Nigeria
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'status' => $data['data']['status'] ?? 'PENDING',
                    'amount' => $data['data']['amount'] ?? 0,
                    'reference' => $data['data']['reference'] ?? $reference,
                    'order_no' => $data['data']['orderNo'] ?? null,
                    'data' => $data['data'] ?? []
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to verify transaction',
                    'response' => $response->body()
                ];
            }

        } catch (\Exception $e) {
            Log::error('OPay Transaction Verification Failed', [
                'reference' => $reference,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Verification service unavailable: ' . $e->getMessage()
            ];
        }
    }

    /**
     * معالجة callback من OPay
     */
    public function handleCallback(array $payload)
    {
        try {
            // التحقق من صحة التوقيع
            if (!$this->verifySignature($payload)) {
                return [
                    'success' => false,
                    'message' => 'Invalid signature'
                ];
            }

            $reference = $payload['reference'] ?? null;
            $status = $payload['status'] ?? 'PENDING';
            $amount = $payload['amount'] ?? 0;

            if (!$reference) {
                return [
                    'success' => false,
                    'message' => 'Missing reference'
                ];
            }

            // البحث عن المعاملة
            $transaction = Transaction::where('transaction_id', $reference)->first();
            
            if (!$transaction) {
                return [
                    'success' => false,
                    'message' => 'Transaction not found'
                ];
            }

            // تحديث حالة المعاملة
            switch (strtoupper($status)) {
                case 'SUCCESS':
                case 'SUCCESSFUL':
                    $transaction->confirm($payload['orderNo'] ?? null, $payload);
                    
                    // إضافة الرصيد للمحفظة
                    $wallet = $transaction->wallet;
                    $wallet->addBalance($transaction->amount, 'تأكيد إيداع عبر OPay');
                    
                    return [
                        'success' => true,
                        'message' => 'Payment confirmed successfully',
                        'transaction' => $transaction
                    ];

                case 'FAILED':
                case 'CANCELLED':
                    $transaction->fail('Payment ' . strtolower($status), $payload);
                    
                    return [
                        'success' => true,
                        'message' => 'Payment ' . strtolower($status),
                        'transaction' => $transaction
                    ];

                default:
                    $transaction->update([
                        'status' => Transaction::STATUS_PROCESSING,
                        'gateway_response' => $payload
                    ]);
                    
                    return [
                        'success' => true,
                        'message' => 'Payment status updated',
                        'transaction' => $transaction
                    ];
            }

        } catch (\Exception $e) {
            Log::error('OPay Callback Processing Failed', [
                'payload' => $payload,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Callback processing failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * إنشاء طلب سحب (Transfer)
     */
    public function createWithdrawal(Transaction $transaction, array $bankDetails)
    {
        try {
            $payload = [
                'reference' => $transaction->transaction_id,
                'amount' => [
                    'total' => (int)($transaction->net_amount * 100),
                    'currency' => $transaction->currency === 'EGP' ? 'EGP' : 'NGN'
                ],
                'receiver' => [
                    'type' => 'USER',
                    'account' => [
                        'bankCode' => $bankDetails['bank_code'] ?? '',
                        'bankAccountNumber' => $bankDetails['account_number'] ?? '',
                        'bankAccountName' => $bankDetails['account_name'] ?? '',
                    ]
                ],
                'reason' => 'Wallet withdrawal'
            ];

            $headers = [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'MerchantId' => $this->merchantId,
                'Content-Type' => 'application/json',
            ];

            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->post($this->baseUrl . '/api/v3/transfer/toBank', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['code'] === '00000') {
                    return [
                        'success' => true,
                        'reference' => $data['data']['reference'],
                        'order_no' => $data['data']['orderNo'],
                        'status' => $data['data']['status'],
                        'message' => 'Withdrawal initiated successfully'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $data['message'] ?? 'Failed to initiate withdrawal',
                        'error_code' => $data['code']
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'HTTP request failed: ' . $response->status()
                ];
            }

        } catch (\Exception $e) {
            Log::error('OPay Withdrawal Creation Failed', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Withdrawal service unavailable: ' . $e->getMessage()
            ];
        }
    }

    /**
     * التحقق من صحة التوقيع
     */
    private function verifySignature(array $payload)
    {
        if (!isset($payload['sign'])) {
            return false;
        }

        $signature = $payload['sign'];
        unset($payload['sign']);

        // ترتيب المعاملات أبجدياً
        ksort($payload);

        // إنشاء النص للتوقيع
        $signString = '';
        foreach ($payload as $key => $value) {
            if (!empty($value)) {
                $signString .= $key . '=' . $value . '&';
            }
        }
        $signString = rtrim($signString, '&');
        $signString .= $this->secretKey;

        // حساب التوقيع
        $calculatedSignature = strtoupper(hash('sha512', $signString));

        return hash_equals($calculatedSignature, strtoupper($signature));
    }

    /**
     * الحصول على قائمة البنوك المدعومة
     */
    public function getSupportedBanks($country = 'EG')
    {
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $this->publicKey,
                'MerchantId' => $this->merchantId,
            ];

            // Use standard endpoint for banks
            $endpoint = '/api/v3/banks';
                
            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->get($this->baseUrl . $endpoint, [
                    'countryCode' => $country
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'banks' => $data['data'] ?? []
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to fetch banks'
                ];
            }

        } catch (\Exception $e) {
            Log::error('OPay Banks Fetch Failed', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Banks service unavailable'
            ];
        }
    }
}
