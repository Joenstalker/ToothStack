<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $this->resolveTenant($request);

        if (! $tenant) {
            // Allow login/register routes without tenant
            if ($this->isPublicRoute($request)) {
                return $next($request);
            }

            abort(404, 'Clinic not found. Please check the URL.');
        }

        // Check if tenant is active
        if (! $tenant->is_active) {
            return redirect()->route('tenant.suspended')
                ->with('error', 'This clinic account has been suspended.');
        }

        // Check subscription status
        if (! in_array($tenant->subscription_status, ['active', 'trial'])) {
            return redirect()->route('tenant.subscription.expired')
                ->with('error', 'Subscription has expired. Please renew.');
        }

        // Check if trial expired
        if ($tenant->isOnTrial() && $tenant->trial_ends_at->isPast()) {
            return redirect()->route('tenant.trial.expired')
                ->with('error', 'Trial period has expired.');
        }

        // Set tenant in app container (available globally)
        app()->instance('tenant', $tenant);

        // Set tenant config (for dedicated database if needed)
        if ($tenant->database_connection) {
            config(['database.default' => $tenant->database_connection]);
        }

        return $next($request);
    }

    /**
     * Resolve tenant from request
     */
    protected function resolveTenant(Request $request): ?Tenant
    {
        // 1. Check subdomain (e.g., clinicA.dentalapp.com)
        $host = $request->getHost();
        $parts = explode('.', $host);

        if (count($parts) >= 2 && $parts[0] !== 'www') {
            $subdomain = $parts[0];
            $tenant = Tenant::where('slug', $subdomain)->first();

            if ($tenant) {
                return $tenant;
            }
        }

        // 2. Check custom domain (e.g., myclinic.com)
        $tenant = Tenant::where('domain', $host)->first();
        if ($tenant) {
            return $tenant;
        }

        // 3. Fallback: If user is logged in, use their tenant
        if (Auth::check() && Auth::user()->tenant_id) {
            return Tenant::find(Auth::user()->tenant_id);
        }

        return null;
    }

    /**
     * Check if route is public (doesn't require tenant)
     */
    protected function isPublicRoute(Request $request): bool
    {
        $path = $request->path();
        
        $publicRoutes = [
            '/',
            'login',
            'register',
            'logout',
            'password/reset',
            'password/email',
        ];

        return in_array($path, $publicRoutes) ||
               str_starts_with($path, 'password/') ||
               str_starts_with($path, 'superadmin/');
    }
}
