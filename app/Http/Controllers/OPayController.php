<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OPayService;
use Illuminate\Support\Facades\Log;

class OPayController extends Controller
{
    protected $opayService;

    public function __construct(OPayService $opayService)
    {
        $this->opayService = $opayService;
    }

    /**
     * معالجة callback من OPay
     */
    public function handleCallback(Request $request)
    {
        try {
            Log::info('OPay Callback Received', $request->all());

            $result = $this->opayService->handleCallback($request->all());

            if ($result['success']) {
                return response()->json([
                    'status' => 'success',
                    'message' => $result['message']
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $result['message']
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('OPay Callback Error', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * التحقق من حالة المعاملة
     */
    public function verifyTransaction(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);

        try {
            $result = $this->opayService->verifyTransaction($request->reference);

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('OPay Verification Error', [
                'reference' => $request->reference,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Verification failed'
            ], 500);
        }
    }

    /**
     * الحصول على البنوك المدعومة
     */
    public function getSupportedBanks(Request $request)
    {
        $country = $request->get('country', 'EG');

        try {
            $result = $this->opayService->getSupportedBanks($country);

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('OPay Banks Fetch Error', [
                'country' => $country,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch banks'
            ], 500);
        }
    }
}
