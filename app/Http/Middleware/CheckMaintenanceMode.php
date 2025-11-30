<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        $maintenanceMode = cache()->get('app.maintenance_mode', false);
        if (!$maintenanceMode) {
            return $next($request);
        }

        // Check if user can bypass
        if (auth()->check() && auth()->user()->can('bypassMaintenance', \App\Models\Setting::class)) {
            return $next($request);
        }

        // Check if it's a login route (allow access to login)
        if ($request->is('admin/login') || $request->is('login')) {
            return $next($request);
        }

        // Show maintenance page
        abort(503, 'Service Unavailable');
    }
}
