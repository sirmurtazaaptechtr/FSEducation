@extends('layouts.public')

@section('meta_title', 'Page Not Found (404) | ' . setting('company_name', 'F.S. Education'))

@section('content')
<div class="container py-5 text-center my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="display-1 fw-bold text-primary mb-3">404</div>
            <h2 class="fw-bold text-dark mb-3">Oops! Page Not Found</h2>
            <p class="text-muted lead fs-6 mb-4">
                The educational programme, centre, or page you were looking for could not be found or may have been relocated.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url('/') }}" class="btn btn-primary fw-semibold px-4">
                    <i class="bi bi-house me-1"></i> Return to Homepage
                </a>
                <a href="{{ url('/courses') }}" class="btn btn-outline-secondary fw-semibold px-4">
                    <i class="bi bi-book me-1"></i> Browse Programmes
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
