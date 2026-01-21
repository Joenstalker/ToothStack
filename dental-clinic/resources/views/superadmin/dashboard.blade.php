<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Super Admin Dashboard - Dental SaaS Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .table-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-top: 2rem;
        }
        .badge-plan {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('superadmin.dashboard') }}">
                <i class="fas fa-shield-alt me-2"></i>Super Admin Dashboard
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">
                    <i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid px-4 py-4">
        
        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">
                        <i class="fas fa-building"></i>
                    </div>
                    <h6 class="text-muted mb-1">Total Tenants</h6>
                    <h2 class="mb-0 fw-bold">{{ $stats['total_tenants'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #d1fae5; color: #065f46;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h6 class="text-muted mb-1">Active Tenants</h6>
                    <h2 class="mb-0 fw-bold">{{ $stats['active_tenants'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fef3c7; color: #92400e;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <h6 class="text-muted mb-1">Trial Tenants</h6>
                    <h2 class="mb-0 fw-bold">{{ $stats['trial_tenants'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #e9d5ff; color: #6b21a8;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6 class="text-muted mb-1">Total Users</h6>
                    <h2 class="mb-0 fw-bold">{{ $stats['total_users'] }}</h2>
                </div>
            </div>
        </div>

        <!-- Recent Tenants & Subscription Plans -->
        <div class="row">
            <!-- Recent Tenants -->
            <div class="col-md-8">
                <div class="table-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold">Recent Tenants</h5>
                        <a href="{{ route('superadmin.tenants.index') }}" class="btn btn-sm btn-primary">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Clinic Name</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTenants as $tenant)
                                <tr>
                                    <td>
                                        <strong>{{ $tenant->name }}</strong><br>
                                        <small class="text-muted">{{ $tenant->slug }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-plan" style="background: {{ $tenant->subscription_plan === 'pro' ? '#3b82f6' : ($tenant->subscription_plan === 'ultimate' ? '#6366f1' : '#6b7280') }}; color: white;">
                                            {{ strtoupper($tenant->subscription_plan) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($tenant->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $tenant->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.tenants.show', $tenant) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No tenants found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Subscription Distribution -->
            <div class="col-md-4">
                <div class="table-card">
                    <h5 class="mb-3 fw-bold">Subscription Plans</h5>
                    @foreach($tenantsByPlan as $plan)
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-0">{{ ucfirst($plan->subscription_plan) }}</h6>
                            <small class="text-muted">Plan</small>
                        </div>
                        <h4 class="mb-0 fw-bold">{{ $plan->count }}</h4>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
