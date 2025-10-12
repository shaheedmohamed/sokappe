<?php

namespace App\Services;

use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActivityLogger
{
    public static function log($userId, $action, $additionalData = null)
    {
        $request = request();
        
        // Get IP address
        $ipAddress = self::getClientIpAddress($request);
        
        // Get location data
        $locationData = self::getLocationFromIp($ipAddress);
        
        // Get device and browser info
        $deviceInfo = self::getDeviceInfo($request);
        
        UserActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'ip_address' => $ipAddress,
            'user_agent' => $request->userAgent(),
            'country' => $locationData['country'] ?? null,
            'city' => $locationData['city'] ?? null,
            'device_type' => $deviceInfo['device_type'],
            'browser' => $deviceInfo['browser'],
            'additional_data' => $additionalData,
        ]);
    }

    private static function getClientIpAddress($request)
    {
        $ipKeys = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',            // Proxy
            'HTTP_X_FORWARDED_FOR',      // Load Balancer/Proxy
            'HTTP_X_FORWARDED',          // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxy
            'HTTP_FORWARDED',            // Proxy
            'REMOTE_ADDR'                // Standard
        ];

        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                $ip = $_SERVER[$key];
                if (strpos($ip, ',') !== false) {
                    $ip = explode(',', $ip)[0];
                }
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $request->ip();
    }

    private static function getLocationFromIp($ip)
    {
        try {
            // Skip for local IPs
            if (in_array($ip, ['127.0.0.1', '::1', 'localhost']) || 
                filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
                return ['country' => 'Local', 'city' => 'Local'];
            }

            // Use ip-api.com (free service)
            $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}?fields=country,city,status");
            
            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    return [
                        'country' => $data['country'] ?? 'Unknown',
                        'city' => $data['city'] ?? 'Unknown'
                    ];
                }
            }
        } catch (\Exception $e) {
            // Log error but don't fail
            \Log::warning('Failed to get location for IP: ' . $ip, ['error' => $e->getMessage()]);
        }

        return ['country' => 'Unknown', 'city' => 'Unknown'];
    }

    private static function getDeviceInfo($request)
    {
        $userAgent = $request->userAgent();
        
        // Detect device type
        $deviceType = 'desktop';
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            if (preg_match('/iPad/', $userAgent)) {
                $deviceType = 'tablet';
            } else {
                $deviceType = 'mobile';
            }
        } elseif (preg_match('/bot|crawler|spider/i', $userAgent)) {
            $deviceType = 'bot';
        }

        // Detect browser
        $browser = 'Unknown';
        if (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        }

        return [
            'device_type' => $deviceType,
            'browser' => $browser
        ];
    }
}
