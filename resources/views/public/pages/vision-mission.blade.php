@extends('layouts.public')

@section('meta_title', $page->meta_title ?: 'Vision & Mission | F.S. Education Group')
@section('meta_description', $page->meta_description ?: 'Our vision to transform potential into professional success and our mission to provide accessible, career-oriented education.')

@section('meta_tags')
    <x-meta-tags
        :title="$page->meta_title ?: $page->title"
        :description="$page->meta_description"
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/about') }}" class="text-white-50 text-decoration-none">About</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Vision & Mission</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">{{ $page->title }}</h1>
        <p class="lead text-white-50 mb-0">{{ setting('tagline', 'Learn Today. Lead Tomorrow.') }}</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="page-content bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-5">
                {!! $page->body !!}
            </div>

            <!-- Core Values -->
            <div class="card border-0 shadow-sm rounded-4 bg-light p-4 p-md-5">
                <h3 class="fw-bold text-center text-dark mb-4">Our Core Values</h3>
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded-3 h-100 shadow-sm">
                            <div class="fs-1 text-primary mb-2"><i class="bi bi-shield-check"></i></div>
                            <h5 class="fw-bold text-dark">Integrity & Transparency</h5>
                            <p class="text-muted small mb-0">Clear statutory disclosures, honest academic guidance, and no inflated promises.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded-3 h-100 shadow-sm">
                            <div class="fs-1 text-warning mb-2"><i class="bi bi-bullseye"></i></div>
                            <h5 class="fw-bold text-dark">Outcome Driven</h5>
                            <p class="text-muted small mb-0">Every programme is calibrated towards marketable competence, employability, and student portfolios.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded-3 h-100 shadow-sm">
                            <div class="fs-1 text-success mb-2"><i class="bi bi-people"></i></div>
                            <h5 class="fw-bold text-dark">Accessibility & Inclusivity</h5>
                            <p class="text-muted small mb-0">Financial accessibility through strategic institutional MOUs and transparent fee structures.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

