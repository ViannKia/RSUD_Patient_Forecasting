<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserOnlineStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Simpan status user online ke cache selama 5 menit sejak aktivitas terakhir
            $expiresAt = now()->addMinutes(1);
            Cache::put('user-is-online-' . Auth::id(), true, $expiresAt);
        }

        return $next($request);
    }
}

