@extends('layouts.public')

@section('meta_title', 'Server Error (500) | ' . setting('company_name', 'F.S. Education'))

@section('content')
<div class="container py-5 text-center my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="display-1 fw-bold text-danger mb-3">500</div>
            <h2 class="fw-bold text-dark mb-3">Unexpected Server Error</h2>
            <p class="text-muted lead fs-6 mb-4">
                We are currently experiencing a brief technical issue. Our systems team has been notified.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url('/') }}" class="btn btn-primary fw-semibold px-4">
                    <i class="bi bi-house me-1"></i> Return to Homepage
                </a>
                <a href="{{ url('/contact') }}" class="btn btn-outline-secondary fw-semibold px-4">
                    <i class="bi bi-envelope me-1"></i> Contact Admissions Desk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
