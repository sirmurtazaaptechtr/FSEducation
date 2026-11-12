@extends('layouts.public')

@section('meta_title', $page->meta_title ?: 'About F.S. Education | Premier Educational Network')
@section('meta_description', $page->meta_description ?: 'Learn about the vision, history, and educational leadership of F.S. Education and its network of technology and creative institutions across Karachi.')

@section('meta_tags')
    <x-meta-tags
        :title="$page->meta_title ?: $page->title"
        :description="$page->meta_description"
    />
@endsection

@section('content')
<!-- Page Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">About Group</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">{{ $page->title }}</h1>
        <p class="lead text-white-50 mb-0">{{ setting('tagline', 'Learn Today. Lead Tomorrow.') }}</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="page-content bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                {!! $page->body !!}
            </div>

            <!-- Group Structure Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-light p-4 mb-4">
                <h4 class="fw-bold text-dark mb-3"><i class="bi bi-diagram-3 text-primary me-2"></i> Our Operating Structure</h4>
                <p class="text-muted small">
                    F.S. Education functions as the parent organization and primary brand. Under its umbrella, it operates proprietary government-registered vocational institutes as well as premier international technology franchises:
                </p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded border card-brand-fs">
                            <span class="badge badge-brand-fs mb-2">Parent Brand</span>
                            <h6 class="fw-bold text-dark mb-1">F.S. Education</h6>
                            <small class="text-muted">SBTE & NAVTTC Registered programmes; institutional MOUs.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded border card-brand-aptech">
                            <span class="badge badge-brand-aptech mb-2">Franchise Network</span>
                            <h6 class="fw-bold text-dark mb-1">Aptech</h6>
                            <small class="text-muted">Global IT education and software engineering certifications.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white rounded border card-brand-arena">
                            <span class="badge badge-brand-arena mb-2">Franchise Network</span>
                            <h6 class="fw-bold text-dark mb-1">Arena Multimedia</h6>
                            <small class="text-muted">Animation, VFX, graphics, and digital media design tracks.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Sidebar Quick Info -->
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h5 class="fw-bold text-dark mb-3">Group Highlights</h5>
                <ul class="list-unstyled d-flex flex-column gap-3 small mb-0">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt text-primary fs-5"></i>
                        <div>
                            <strong class="text-dark d-block">Network Reach</strong>
                            <span class="text-muted">5 strategic centres across Karachi</span>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-patch-check text-success fs-5"></i>
                        <div>
                            <strong class="text-dark d-block">Regulatory Alignment</strong>
                            <span class="text-muted">Registered with SBTE & NAVTTC (designated programmes)</span>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-handshake text-warning fs-5"></i>
                        <div>
                            <strong class="text-dark d-block">Partner Ecosystem</strong>
                            <span class="text-muted">Institutional MOUs with corporate & academic bodies</span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Need Admission Help -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-fs-navy text-white text-center">
                <h5 class="fw-bold mb-2">Ready to Start?</h5>
                <p class="text-white-50 small mb-4">Consult our admissions advisors for guidance on courses, eligibility, and scholarship/MOU options.</p>
                <a href="{{ url('/contact#inquiry-form') }}" class="btn btn-warning fw-bold w-100 mb-2">Apply for Admission</a>
                <a href="{{ url('/centres') }}" class="btn btn-outline-light w-100">Find a Centre</a>
            </div>
        </div>
    </div>
</div>
@endsection

