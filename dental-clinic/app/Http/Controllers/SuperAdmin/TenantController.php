<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function index(): View
    {
        $tenants = Tenant::latest()->paginate(20);

        return view('superadmin.tenants.index', compact('tenants'));
    }

    public function create(): View
    {
        return view('superadmin.tenants.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tenants,slug',
            'subscription_plan' => 'required|in:basic,pro,ultimate',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'max_users' => 'required|integer|min:1',
            'max_patients' => 'required|integer|min:1',
        ]);

        $validated['subscription_status'] = 'trial';
        $validated['trial_ends_at'] = now()->addDays(14);
        $validated['is_active'] = true;

        Tenant::create($validated);

        return redirect()->route('superadmin.tenants.index')
            ->with('success', 'Tenant created successfully!');
    }

    public function show(Tenant $tenant): View
    {
        $tenant->load(['users', 'patients', 'subscriptions']);

        return view('superadmin.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant): View
    {
        return view('superadmin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tenants,slug,'.$tenant->id,
            'subscription_plan' => 'required|in:basic,pro,ultimate',
            'subscription_status' => 'required|in:active,trial,suspended,cancelled',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'max_users' => 'required|integer|min:1',
            'max_patients' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $tenant->update($validated);

        return redirect()->route('superadmin.tenants.show', $tenant)
            ->with('success', 'Tenant updated successfully!');
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        $tenant->delete();

        return redirect()->route('superadmin.tenants.index')
            ->with('success', 'Tenant deleted successfully!');
    }

    public function suspend(Tenant $tenant): RedirectResponse
    {
        $tenant->update([
            'subscription_status' => 'suspended',
            'is_active' => false,
        ]);

        return back()->with('success', 'Tenant suspended successfully!');
    }

    public function activate(Tenant $tenant): RedirectResponse
    {
        $tenant->update([
            'subscription_status' => 'active',
            'is_active' => true,
        ]);

        return back()->with('success', 'Tenant activated successfully!');
    }
}
