<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        if(auth()->check() && auth()->user()->bannedUntil && now()->isBefore(auth()->user()->bannedUntil))
        {	
            $bannedDays = now()->diffInDays(auth()->user()->bannedUntil);
            
            auth()->logout();

            $message = 'Sua conta foi suspensa por '. $bannedDays .' '. Str::plural('dia', $bannedDays);

            return redirect()->route('login')->withMessage($message);
        }
        
        return $next($request);
    }
}
