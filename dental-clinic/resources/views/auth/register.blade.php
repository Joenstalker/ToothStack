@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="color: #1f2937;">Create Account</h2>
        <p class="text-muted mb-0">Sign up to get started with ToothStack</p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <div class="mb-4">
            <label for="name" class="form-label">
                <i class="fas fa-user"></i> Full Name
            </label>
            <input 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus
                autocomplete="name"
                placeholder="John Doe"
            >
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

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
                    autocomplete="new-password"
                    placeholder="Create a strong password"
                    minlength="8"
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
            <small class="form-text text-muted">
                <i class="fas fa-info-circle me-1"></i> Minimum 8 characters
            </small>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock"></i> Confirm Password
            </label>
            <div class="input-group position-relative">
                <input 
                    type="password" 
                    class="form-control" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                    autocomplete="new-password"
                    placeholder="Confirm your password"
                    minlength="8"
                >
                <button 
                    type="button" 
                    class="password-toggle" 
                    onclick="togglePassword('password_confirmation')"
                    aria-label="Toggle password visibility"
                >
                    <i class="fas fa-eye" id="password_confirmationToggleIcon"></i>
                </button>
            </div>
            <div id="passwordMatch" class="mt-2" style="display: none;"></div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3" style="padding: 0.875rem;">
            <i class="fas fa-user-plus me-2"></i>Create Account
        </button>

        <div class="text-center">
            <p class="mb-0 text-muted small">
                Already have an account? 
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Sign in</a>
            </p>
        </div>
    </form>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const iconId = inputId + 'ToggleIcon';
            const icon = document.getElementById(iconId);
            
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

        // Password match validation
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const passwordMatch = document.getElementById('passwordMatch');

        function checkPasswordMatch() {
            if (passwordConfirmation.value.length > 0) {
                if (password.value === passwordConfirmation.value) {
                    passwordConfirmation.classList.remove('is-invalid');
                    passwordConfirmation.classList.add('is-valid');
                    passwordMatch.innerHTML = '<small class="text-success"><i class="fas fa-check-circle me-1"></i>Passwords match</small>';
                    passwordMatch.style.display = 'block';
                } else {
                    passwordConfirmation.classList.remove('is-valid');
                    passwordConfirmation.classList.add('is-invalid');
                    passwordMatch.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle me-1"></i>Passwords do not match</small>';
                    passwordMatch.style.display = 'block';
                }
            } else {
                passwordMatch.style.display = 'none';
            }
        }

        passwordConfirmation.addEventListener('input', checkPasswordMatch);
        password.addEventListener('input', checkPasswordMatch);

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (password.value !== passwordConfirmation.value) {
                e.preventDefault();
                passwordConfirmation.classList.add('is-invalid');
                passwordMatch.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle me-1"></i>Passwords must match</small>';
                passwordMatch.style.display = 'block';
            }
        });
    </script>
@endsection
