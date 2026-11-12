@extends('layouts.public')

@section('meta_title', $page->meta_title ?: 'Why Choose F.S. Education | Proven Career Outcomes')
@section('meta_description', $page->meta_description ?: 'Discover what makes F.S. Education different: certified faculty, hands-on labs, industry affiliations, and guaranteed student discounts through partner MOUs.')

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
                <li class="breadcrumb-item text-white active" aria-current="page">Why Us</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">{{ $page->title }}</h1>
        <p class="lead text-white-50 mb-0">Practical skills, institutional credibility, and affordable learning paths</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="page-content bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-5">
                {!! $page->body !!}
            </div>

            <!-- Stats strip -->
            @if($stats->isNotEmpty())
                <div class="row g-3 mb-5">
                    @foreach($stats as $s)
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded text-center border">
                                <div class="fs-3 fw-bold text-primary">{{ $s->value }}{{ $s->suffix }}</div>
                                <small class="text-muted fw-semibold text-uppercase" style="font-size: 0.75rem;">{{ $s->label }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Testimonials excerpt -->
            @if($testimonials->isNotEmpty())
                <div class="mb-4">
                    <h4 class="fw-bold text-dark mb-4"><i class="bi bi-chat-quote text-warning me-2"></i> Alumni Experiences</h4>
                    <div class="row g-4">
                        @foreach($testimonials as $t)
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm p-4 bg-light">
                                    <p class="small text-muted fst-italic mb-3">"{{ $t->quote }}"</p>
                                    <div class="d-flex align-items-center gap-2 pt-2 border-top">
                                        <strong class="text-dark small">{{ $t->name }}</strong>
                                        <small class="text-muted">({{ $t->role_or_course }})</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light mb-4">
                <h5 class="fw-bold text-dark mb-3">Quick Navigation</h5>
                <div class="list-group list-group-flush small">
                    <a href="{{ url('/courses') }}" class="list-group-item list-group-item-action bg-transparent px-0"><i class="bi bi-book me-2 text-primary"></i> Browse Programmes</a>
                    <a href="{{ url('/centres') }}" class="list-group-item list-group-item-action bg-transparent px-0"><i class="bi bi-building me-2 text-primary"></i> Campus Locations</a>
                    <a href="{{ url('/accreditations') }}" class="list-group-item list-group-item-action bg-transparent px-0"><i class="bi bi-award me-2 text-primary"></i> SBTE & NAVTTC Registrations</a>
                    <a href="{{ url('/mou-partners') }}" class="list-group-item list-group-item-action bg-transparent px-0"><i class="bi bi-percent me-2 text-primary"></i> Partner Discount Subsidies</a>
                    <a href="{{ url('/contact') }}" class="list-group-item list-group-item-action bg-transparent px-0"><i class="bi bi-envelope me-2 text-primary"></i> Contact Admissions</a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 bg-fs-navy text-white text-center">
                <h5 class="fw-bold mb-2">Speak to an Advisor</h5>
                <p class="text-white-50 small mb-3">Have questions about syllabus, batches, timings, or tuition fees? Our counselors are ready to help.</p>
                <a href="{{ url('/contact#inquiry-form') }}" class="btn btn-warning fw-bold w-100">Get in Touch</a>
            </div>
        </div>
    </div>
</div>
@endsection
