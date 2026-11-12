@extends('layouts.public')

@section('meta_title', $page->meta_title ?: 'Accreditations & Government Affiliations | SBTE & NAVTTC | F.S. Education')
@section('meta_description', $page->meta_description ?: 'Learn how F.S. Education delivers programmes registered with SBTE (Sindh Board of Technical Education) and NAVTTC (National Vocational & Technical Training Commission).')

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
                <li class="breadcrumb-item text-white active" aria-current="page">Accreditations & Affiliations</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">{{ $page->title }}</h1>
        <p class="lead text-white-50 mb-0">Statutory legitimacy, board registrations, and programme transparency</p>
    </div>
</div>

<div class="container py-5">
    <!-- Intro text from Page -->
    <div class="page-content bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-5">
        {!! $page->body !!}
    </div>

    <!-- Mandatory Statutory Disclosure Banner (Business Rule 5 & 9) -->
    <div class="card border-primary border-opacity-25 bg-primary bg-opacity-10 shadow-sm rounded-4 p-4 mb-5">
        <div class="d-flex align-items-start gap-3">
            <div class="fs-2 text-primary"><i class="bi bi-shield-check"></i></div>
            <div>
                <h5 class="fw-bold text-dark mb-2">Registration Governance Statement</h5>
                <p class="text-secondary mb-2">
                    {{ setting('registration_statement', 'The network operates through institutions registered with relevant education and skills-development authorities, including SBTE and NAVTTC, subject to the respective centre and approved programme registrations.') }}
                </p>
                <div class="small text-muted">
                    <strong class="text-dark">Regulatory Note:</strong> Government affiliations (such as SBTE or NAVTTC) are associated exclusively with designated F.S. Education proprietary courses. Franchise operations under Aptech Computer Education and Arena Multimedia operate independently in accordance with international franchisor academic guidelines and are not affiliated with provincial or national technical boards.
                </div>
            </div>
        </div>
    </div>

    <!-- Affiliation Governing Bodies Overview -->
    <h3 class="fw-bold text-dark mb-4">Recognized Governing Bodies</h3>
    <div class="row g-4 mb-5">
        @foreach($affiliations as $aff)
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm p-4 bg-white rounded-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if($aff->logo)
                            <img src="{{ asset('storage/' . $aff->logo) }}" alt="{{ $aff->name }}" style="height: 54px; object-fit: contain;">
                        @else
                            <div class="rounded bg-light text-primary d-flex align-items-center justify-content-center fs-2" style="width: 54px; height: 54px;">
                                <i class="bi bi-award"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">{{ $aff->short_name }}</h4>
                            <small class="text-muted">{{ $aff->name }}</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-3 flex-grow-1">{{ $aff->description }}</p>
                    @if($aff->website_url)
                        <div class="pt-2 border-top">
                            <a href="{{ $aff->website_url }}" target="_blank" rel="noopener" class="text-decoration-none small text-primary fw-semibold">
                                Visit Official Regulatory Portal <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Approved F.S. Education Programmes (Business Rule 4 & 5) -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Approved Programmes (Per-Programme Register)</h3>
            <p class="text-muted small mb-0">The following courses have explicit statutory registration and approval:</p>
        </div>
        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 fs-6">
            <i class="bi bi-patch-check-fill me-1"></i> {{ $approvedCourses->count() }} Approved Programmes
        </span>
    </div>

    @if($approvedCourses->isNotEmpty())
        <div class="row g-4">
            @foreach($approvedCourses as $c)
                <div class="col-md-6 col-lg-4 course-col">
                    <x-course-card :course="$c" />
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-secondary text-center py-4">
            No approved programmes currently published under this register.
        </div>
    @endif
</div>
@endsection
