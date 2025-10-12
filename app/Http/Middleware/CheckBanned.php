<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_banned) {
            $user = Auth::user();
            $bannedReason = $user->banned_reason;
            
            Auth::logout();
            
            return redirect()->route('login')->with('error', 
                '🚫 تم حظر حسابك من المنصة. ' . 
                ($bannedReason ? 'السبب: ' . $bannedReason . '. ' : '') .
                'للاستفسار، يرجى التواصل مع خدمة العملاء.'
            );
        }

        return $next($request);
    }
}
