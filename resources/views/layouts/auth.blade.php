<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sign In') | {{ setting('company_name', 'F.S. Education') }}</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light d-flex align-items-center min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="text-decoration-none">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle shadow-sm mb-2" style="width: 56px; height: 56px;">
                            <i class="bi bi-mortarboard-fill fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-0">{{ setting('company_name', 'F.S. Education') }}</h4>
                        <small class="text-muted text-uppercase letter-spacing-1 font-monospace" style="font-size: 0.7rem;">{{ setting('tagline', 'Learn Today. Lead Tomorrow.') }}</small>
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        @yield('content')
                    </div>
                </div>

                <div class="text-center mt-3 text-muted small">
                    &copy; {{ date('Y') }} {{ setting('company_name', 'F.S. Education') }}. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
