<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_tenants' => Tenant::count(),
            'active_tenants' => Tenant::where('is_active', true)->count(),
            'trial_tenants' => Tenant::where('subscription_status', 'trial')->count(),
            'total_users' => User::withoutGlobalScopes()->count(),
            'total_patients' => Patient::withoutGlobalScopes()->count(),
        ];

        $recentTenants = Tenant::latest()->take(5)->get();
        
        $tenantsByPlan = Tenant::selectRaw('subscription_plan, count(*) as count')
            ->groupBy('subscription_plan')
            ->get();

        return view('superadmin.dashboard', compact('stats', 'recentTenants', 'tenantsByPlan'));
    }
}
