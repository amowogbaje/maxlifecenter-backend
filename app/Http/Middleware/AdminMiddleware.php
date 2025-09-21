<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->is_admin) {
            return $next($request);
        }

        // if ($request->ajax() || $request->wantsJson()) {
        //     return response('Unauthorized.', 401);
        // }
        
        // return redirect()->guest(route('admin.login'))->with('error', 'You need admin privileges to access this page.');
        return redirect()->route('admin.login');
        
        // Alternatively, you can show a forbidden page:
        // abort(403, 'Access denied. Admin privileges required.');
    }
}