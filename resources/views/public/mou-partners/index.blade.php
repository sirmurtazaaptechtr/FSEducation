@extends('layouts.public')

@section('meta_title', 'Institutional MOU Partners & Student Discounts | F.S. Education')
@section('meta_description', 'Explore verified tuition discounts and educational fee subsidies available to students and employees of our institutional MOU partner organizations.')

@section('meta_tags')
    <x-meta-tags
        title="Institutional MOU Partners & Student Discounts"
        description="Explore verified tuition discounts and educational fee subsidies available to students and employees of our institutional MOU partner organizations."
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">MOU Partners</li>
            </ol>
        </nav>
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <span class="badge bg-warning text-dark px-3 py-1 mb-2 fw-bold text-uppercase">Subsidized Education</span>
                <h1 class="display-5 fw-bold mb-1">MOU Partner Subsidies</h1>
                <p class="lead text-white-50 mb-0">Agreed tuition discounts for members, students, and staff of affiliated entities</p>
            </div>
            <div>
                <a href="{{ url('/become-a-partner') }}" class="btn btn-warning fw-bold px-4 shadow">
                    <i class="bi bi-handshake me-1"></i> Partner With Us
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Explanatory Notice -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-5 bg-light">
        <div class="row align-items-center g-3">
            <div class="col-md-8">
                <h5 class="fw-bold text-dark mb-1"><i class="bi bi-info-circle text-primary me-2"></i> How MOU Discounts Work</h5>
                <p class="text-muted small mb-0">
                    F.S. Education enters bilateral Memorandums of Understanding (MOUs) with universities, colleges, schools, corporate enterprises, and NGOs. Registered beneficiaries receive designated tuition discounts upon presenting their institutional affiliation card or referral code during admission.
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ url('/become-a-partner') }}" class="btn btn-outline-primary btn-sm fw-semibold">
                    Request an Institutional MOU for Your Organization
                </a>
            </div>
        </div>
    </div>

    <!-- Active MOUs Grid -->
    <div class="row g-4">
        @forelse($partners as $partner)
            <div class="col-md-6 col-lg-4">
                <x-mou-card :partner="$partner" />
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center py-5 rounded-4">
                    <i class="bi bi-handshake fs-1 text-muted d-block mb-3"></i>
                    <h5 class="fw-bold text-dark">No Active MOU Partners Currently Listed</h5>
                    <p class="text-muted small mb-3">We are actively onboarding institutional partners. Check back soon or register your institution.</p>
                    <a href="{{ url('/become-a-partner') }}" class="btn btn-primary btn-sm">Become a Partner</a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
