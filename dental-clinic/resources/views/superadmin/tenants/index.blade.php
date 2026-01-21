<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Tenants - Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; }
        .navbar { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important; }
        .content-card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('superadmin.dashboard') }}">
                <i class="fas fa-shield-alt me-2"></i>Super Admin
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0 fw-bold">
                    <i class="fas fa-building text-primary me-2"></i>All Tenants
                </h3>
                <a href="{{ route('superadmin.tenants.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Tenant
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Clinic Name</th>
                            <th>Slug</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Users</th>
                            <th>Patients</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->id }}</td>
                            <td>
                                <strong>{{ $tenant->name }}</strong><br>
                                <small class="text-muted">{{ $tenant->contact_email }}</small>
                            </td>
                            <td><code>{{ $tenant->slug }}</code></td>
                            <td>
                                <span class="badge" style="background: {{ $tenant->subscription_plan === 'pro' ? '#3b82f6' : ($tenant->subscription_plan === 'ultimate' ? '#6366f1' : '#6b7280') }};">
                                    {{ strtoupper($tenant->subscription_plan) }}
                                </span>
                            </td>
                            <td>
                                @if($tenant->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Suspended</span>
                                @endif
                            </td>
                            <td>{{ $tenant->users()->count() }} / {{ $tenant->max_users }}</td>
                            <td>{{ $tenant->patients()->count() }} / {{ $tenant->max_patients }}</td>
                            <td>{{ $tenant->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('superadmin.tenants.show', $tenant) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('superadmin.tenants.edit', $tenant) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">No tenants found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $tenants->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
