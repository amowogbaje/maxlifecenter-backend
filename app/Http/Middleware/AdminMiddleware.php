<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Only handle admin guard
        if (Auth::guard('admin')->check()) {

            // Check if this route is using the guest.admin middleware
            $routeMiddleware = $request->route()?->gatherMiddleware() ?? [];

            $isGuestRoute = collect($routeMiddleware)
                ->contains(fn ($mw) => str_contains($mw, 'guest.admin'));

            // If it's a guest route, redirect to dashboard
            if ($isGuestRoute) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}