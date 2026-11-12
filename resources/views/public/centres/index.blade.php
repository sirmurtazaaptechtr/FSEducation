@extends('layouts.public')

@section('meta_title', 'Campus Locations & Centres | F.S. Education Karachi')
@section('meta_description', 'Discover all five educational centres across Karachi operated by F.S. Education, including Aptech and Arena Multimedia franchise campuses.')

@section('meta_tags')
    <x-meta-tags
        title="Our Campus Locations in Karachi"
        description="Discover all five educational centres across Karachi operated by F.S. Education, including Aptech and Arena Multimedia franchise campuses."
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Centres</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">Our Campus Network</h1>
        <p class="lead text-white-50 mb-0">Explore our five modern learning centres strategically located across Karachi</p>
    </div>
</div>

<div class="container py-5">
    <!-- Brand Filter Pills -->
    <div class="d-flex flex-wrap gap-2 mb-4 align-items-center">
        <span class="text-muted small fw-semibold me-2"><i class="bi bi-funnel me-1"></i> Filter by Brand:</span>
        <a href="{{ url('/centres') }}" class="btn btn-sm {{ !$selectedBrandSlug ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3">
            All Campuses ({{ $centres->count() }})
        </a>
        @foreach($brands as $b)
            <a href="{{ url('/centres?brand=' . $b->slug) }}" class="btn btn-sm {{ $selectedBrandSlug === $b->slug ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3">
                {{ $b->name }}
            </a>
        @endforeach
    </div>

    <!-- Centres Grid -->
    <div class="row g-4">
        @forelse($centres as $centre)
            <div class="col-md-6 col-lg-4">
                <x-centre-card :centre="$centre" />
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                    No centres found matching your selection.
                    <div class="mt-3">
                        <a href="{{ url('/centres') }}" class="btn btn-primary btn-sm">Clear Filter</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

