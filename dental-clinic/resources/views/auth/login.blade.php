@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="color: #1f2937;">Welcome Back</h2>
        <p class="text-muted mb-0">Sign in to continue to your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">
                <i class="fas fa-envelope"></i> Email Address
            </label>
            <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                id="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus
                autocomplete="email"
                placeholder="name@example.com"
            >
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i> Password
            </label>
            <div class="input-group position-relative">
                <input 
                    type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    id="password" 
                    name="password" 
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                >
                <button 
                    type="button" 
                    class="password-toggle" 
                    onclick="togglePassword('password')"
                    aria-label="Toggle password visibility"
                >
                    <i class="fas fa-eye" id="passwordToggleIcon"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input 
                    type="checkbox" 
                    class="form-check-input" 
                    id="remember" 
                    name="remember"
                >
                <label class="form-check-label" for="remember" style="cursor: pointer;">
                    Remember me
                </label>
            </div>
            <a href="#" class="text-decoration-none small">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3" style="padding: 0.875rem;">
            <i class="fas fa-sign-in-alt me-2"></i>Sign In
        </button>

        <div class="text-center">
            <p class="mb-0 text-muted small">
                Don't have an account? 
                <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Create one</a>
            </p>
        </div>
    </form>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + 'ToggleIcon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Form validation feedback
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            
            if (!email.value || !password.value) {
                e.preventDefault();
                if (!email.value) {
                    email.classList.add('is-invalid');
                }
                if (!password.value) {
                    password.classList.add('is-invalid');
                }
            }
        });
    </script>
@endsection
