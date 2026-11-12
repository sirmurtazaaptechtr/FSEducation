@extends('layouts.public')

@section('meta_title', $page->meta_title ?: 'Our Educational Network | 5 Centres Across Karachi | F.S. Education')
@section('meta_description', $page->meta_description ?: 'Explore the five specialised education centres operating across Karachi under the F.S. Education parent brand and premier franchise partners.')

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
                <li class="breadcrumb-item text-white active" aria-current="page">Our Network</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">{{ $page->title }}</h1>
        <p class="lead text-white-50 mb-0">Five modern learning centres operating across prime locations in Karachi</p>
    </div>
</div>

<div class="container py-5">
    <!-- Intro text from Page content -->
    <div class="page-content bg-white p-4 rounded-4 shadow-sm border mb-5">
        {!! $page->body !!}
    </div>

    <!-- Centres grouped by Brand -->
    <div class="d-flex flex-column gap-5">
        @foreach($brands as $brand)
            <div class="brand-group-section">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="height: 42px; object-fit: contain;">
                        @endif
                        <div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $brand->name }}</h3>
                            <small class="text-muted">{{ $brand->description }}</small>
                        </div>
                    </div>
                    <x-brand-badge :brand="$brand" class="fs-6 px-3 py-2" />
                </div>

                {{-- Franchisor Brand Compliance Notice (Business Rule 2) --}}
                @if(in_array($brand->slug, ['aptech', 'arena-multimedia']))
                    <div class="franchise-guideline-box mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock-fill fs-5"></i>
                            <div>
                                <strong>Franchisor Brand Guidelines:</strong>
                                This section and its academic centres operate under authorized franchise agreements with {{ $brand->name }}. All course curricula, trade dress, certifications, and academic delivery follow franchisor brand standards.
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row g-4">
                    @forelse($brand->centres as $centre)
                        <div class="col-md-6 col-lg-4">
                            <x-centre-card :centre="$centre" />
                        </div>
                    @empty
                        <div class="col-12 text-muted text-center py-4 bg-light rounded">
                            No campuses active currently under {{ $brand->name }}.
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
