@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <h5 class="fw-bold mb-1 text-dark">Password Recovery</h5>
    <p class="text-muted small mb-4">Enter your registered email address to receive a secure password reset link.</p>

    @if (session('status'))
        <div class="alert alert-success small py-2 mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label small fw-bold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-envelope text-muted"></i></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="name@fseducation.pk">
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3">
            Send Reset Link
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to sign in
            </a>
        </div>
    </form>
@endsection
