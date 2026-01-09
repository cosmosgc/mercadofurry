<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UpdateLastOnline
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (
                !$user->last_online_at ||
                $user->last_online_at->diffInMinutes(now()) >= 2
            ) {
                Auth::user()->update([
                    'last_online_at' => now(),
                ]);
            }
        }


        return $next($request);
    }
}
