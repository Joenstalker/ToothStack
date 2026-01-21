<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tenant->name }} - Tenant Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; }
        .navbar { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important; }
        .content-card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 1.5rem; }
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('superadmin.tenants.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <h3 class="mb-0 fw-bold">{{ $tenant->name }}</h3>
            </div>
            <div>
                @if($tenant->is_active)
                    <form method="POST" action="{{ route('superadmin.tenants.suspend', $tenant) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Suspend this tenant?')">
                            <i class="fas fa-pause-circle me-1"></i>Suspend
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('superadmin.tenants.activate', $tenant) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-play-circle me-1"></i>Activate
                        </button>
                    </form>
                @endif
                <a href="{{ route('superadmin.tenants.edit', $tenant) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tenant Info -->
        <div class="row">
            <div class="col-md-6">
                <div class="content-card">
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle text-primary me-2"></i>Basic Information</h5>
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">ID:</th>
                            <td>{{ $tenant->id }}</td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td><code>{{ $tenant->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Domain:</th>
                            <td>{{ $tenant->domain ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Contact Email:</th>
                            <td>{{ $tenant->contact_email }}</td>
                        </tr>
                        <tr>
                            <th>Contact Phone:</th>
                            <td>{{ $tenant->contact_phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($tenant->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Suspended</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="content-card">
                    <h5 class="fw-bold mb-3"><i class="fas fa-credit-card text-success me-2"></i>Subscription</h5>
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">Plan:</th>
                            <td>
                                <span class="badge" style="background: {{ $tenant->subscription_plan === 'pro' ? '#3b82f6' : ($tenant->subscription_plan === 'ultimate' ? '#6366f1' : '#6b7280') }};">
                                    {{ strtoupper($tenant->subscription_plan) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td><span class="badge bg-info">{{ ucfirst($tenant->subscription_status) }}</span></td>
                        </tr>
                        <tr>
                            <th>Trial Ends:</th>
                            <td>{{ $tenant->trial_ends_at ? $tenant->trial_ends_at->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Max Users:</th>
                            <td>{{ $tenant->max_users }}</td>
                        </tr>
                        <tr>
                            <th>Max Patients:</th>
                            <td>{{ $tenant->max_patients }}</td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $tenant->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="content-card">
            <h5 class="fw-bold mb-3"><i class="fas fa-users text-info me-2"></i>Users ({{ $tenant->users->count() }} / {{ $tenant->max_users }})</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenant->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-secondary">{{ $user->role->name ?? 'N/A' }}</span></td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No users yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Patients -->
        <div class="content-card">
            <h5 class="fw-bold mb-3"><i class="fas fa-user-injured text-warning me-2"></i>Patients ({{ $tenant->patients->count() }} / {{ $tenant->max_patients }})</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenant->patients as $patient)
                        <tr>
                            <td><code>{{ $patient->patient_code }}</code></td>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ $patient->email }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No patients yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
