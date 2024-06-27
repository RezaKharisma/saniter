<?php

namespace App\Http\Middleware;

use App\Models\Regional;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $regional = Regional::select('timezone')->where('id', auth()->user()->regional_id)->first();
            $jamTimezoneUser = $regional->timezone;
            config(['app.timezone' => $jamTimezoneUser]);
            date_default_timezone_set($jamTimezoneUser);
        }

        return $next($request);
    }
}
