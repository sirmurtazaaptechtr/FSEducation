@extends('layouts.public')

@section('meta_title', 'Programmes & Courses | F.S. Education Network Karachi')
@section('meta_description', 'Explore certified IT, multimedia, vocational and professional training courses across F.S. Education, Aptech, and Arena Multimedia centres in Karachi.')

@section('meta_tags')
    <x-meta-tags
        title="Programmes & Courses Catalogue"
        description="Explore certified IT, multimedia, vocational and professional training courses across F.S. Education, Aptech, and Arena Multimedia centres in Karachi."
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Courses & Programmes</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">Programmes & Courses</h1>
        <p class="lead text-white-50 mb-0">Browse our comprehensive catalogue of diploma, certificate, and franchise training tracks</p>
    </div>
</div>

<div class="container py-5">
    <!-- Filter Card Toolbar (Vanilla JS live search & filtering) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-5 bg-light" id="course-filters-form">
        <div class="row g-3 align-items-end">
            <!-- Search Input -->
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-search me-1"></i> Search Course</label>
                <input type="text" id="filter-search" class="form-control" placeholder="Search by title or topic..." value="{{ $searchQuery }}">
            </div>

            <!-- Brand Filter -->
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-tag me-1"></i> Brand</label>
                <select id="filter-brand" class="form-select">
                    <option value="">All Brands</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->slug }}" {{ $selectedBrand === $b->slug ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-folder me-1"></i> Category</label>
                <select id="filter-category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ $selectedCategory === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Centre Filter -->
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-geo-alt me-1"></i> Centre</label>
                <select id="filter-centre" class="form-select">
                    <option value="">All Centres</option>
                    @foreach($centres as $c)
                        <option value="{{ $c->id }}" {{ $selectedCentre == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Affiliation Filter -->
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted mb-1"><i class="bi bi-award me-1"></i> Affiliation</label>
                <select id="filter-affiliation" class="form-select">
                    <option value="">All Affiliations</option>
                    @foreach($affiliations as $aff)
                        <option value="{{ $aff->short_name }}" {{ $selectedAffiliation === $aff->short_name ? 'selected' : '' }}>{{ $aff->short_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top small">
            <div>
                Showing <strong id="course-results-count" class="text-primary">{{ $courses->count() }}</strong> programmes
            </div>
            <button type="button" id="filter-reset" class="btn btn-link btn-sm text-decoration-none text-muted p-0">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
            </button>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="row g-4" id="courses-grid">
        @foreach($courses as $course)
            <div class="col-md-6 col-lg-4 course-col">
                <x-course-card :course="$course" />
            </div>
        @endforeach
    </div>

    <!-- Empty State -->
    <div id="course-empty-state" class="alert alert-light text-center py-5 border shadow-sm rounded-4 mt-4 d-none">
        <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
        <h5 class="fw-bold text-dark">No programmes match your current filters</h5>
        <p class="text-muted small mb-3">Try adjusting your search criteria, clearing the brand selection, or choosing a different category.</p>
        <button type="button" onclick="document.getElementById('filter-reset').click();" class="btn btn-outline-primary btn-sm">
            Reset All Filters
        </button>
    </div>
</div>
@endsection
