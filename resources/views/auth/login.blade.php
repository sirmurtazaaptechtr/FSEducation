@extends('layouts.auth')

@section('title', 'Admin Sign In')

@section('content')
    <h5 class="fw-bold mb-1 text-dark">Portal Access</h5>
    <p class="text-muted small mb-4">Sign in to manage centres, courses, and partnerships.</p>

    @if(session('status'))
        <div class="alert alert-info small py-2 mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label small fw-bold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-envelope text-muted"></i></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@fseducation.pk">
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="password" class="form-label small fw-bold mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a class="small text-decoration-none" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text bg-white"><i class="bi bi-lock text-muted"></i></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label small" for="remember_me">Keep me signed in</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Portal
        </button>
    </form>
@endsection
