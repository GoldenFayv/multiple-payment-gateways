<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && is_null($user->email_verified_at)) {
            $route = $user instanceof Admin
                ? 'filament.admin.pages.verify-mail'
                : 'filament.merchant.pages.verify-mail';

            // ← prevent redirect loop by checking current route
            if ($request->routeIs($route)) {
                return $next($request);
            }

            return redirect()->route($route);
        }

        return $next($request);
    }
}
