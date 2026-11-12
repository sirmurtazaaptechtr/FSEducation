@extends('layouts.public')

@section('meta_title', ($partner->meta_title ?: $partner->name . ' - Student Discount MOU') . ' | F.S. Education')
@section('meta_description', Str::limit($partner->meta_description ?: ($partner->short_description ?: $partner->description), 160))

@section('meta_tags')
    <x-meta-tags
        :title="$partner->meta_title ?: $partner->name . ' - Student Discount MOU'"
        :description="$partner->meta_description ?: ($partner->short_description ?: $partner->description)"
        :image="$partner->cover_image ?: $partner->logo"
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/mou-partners') }}" class="text-white-50 text-decoration-none">MOU Partners</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">{{ $partner->name }}</li>
            </ol>
        </nav>
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                @if($partner->logo)
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" style="width: 64px; height: 64px; object-fit: contain;" class="bg-white rounded p-1 border">
                @endif
                <div>
                    <span class="badge bg-warning text-dark text-capitalize mb-1">{{ $partner->organization_type }}</span>
                    <h1 class="display-5 fw-bold mb-0">{{ $partner->name }}</h1>
                </div>
            </div>
            <div>
                <x-share-buttons :title="$partner->name . ' - Discount MOU at F.S. Education'" />
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <!-- Cover image if available -->
            @if($partner->cover_image)
                <div class="rounded-4 overflow-hidden shadow-sm mb-4" style="max-height: 380px;">
                    <img src="{{ asset('storage/' . $partner->cover_image) }}" alt="{{ $partner->name }}" class="w-100 h-100 object-fit-cover">
                </div>
            @endif

            <!-- Discount Highlight Strip -->
            <div class="card border-primary border-opacity-25 bg-primary bg-opacity-10 shadow-sm rounded-4 p-4 mb-4 text-center">
                <span class="text-uppercase small fw-bold text-primary letter-spacing-1 d-block mb-1">Agreed MOU Subsidy</span>
                <h2 class="display-5 fw-bold text-dark mb-2">{{ $partner->discount_label }}</h2>
                @if($partner->referral_code)
                    <div class="d-inline-flex align-items-center gap-2 bg-white px-3 py-2 rounded border mt-2">
                        <span class="small text-muted">Beneficiary Referral Code:</span>
                        <code class="fs-5 text-dark fw-bold font-monospace">{{ $partner->referral_code }}</code>
                    </div>
                @endif
            </div>

            <!-- About the Partner & Agreement -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                <h4 class="fw-bold text-dark mb-3">About this Partnership</h4>
                <div class="text-secondary lead fs-6 mb-4">
                    {!! nl2br(e($partner->description ?: $partner->short_description)) !!}
                </div>

                <!-- Terms & Conditions -->
                @if($partner->terms)
                    <h5 class="fw-bold text-dark mt-4 mb-2"><i class="bi bi-file-earmark-text text-primary me-2"></i> Terms & Eligibility</h5>
                    <div class="p-3 bg-light rounded-3 small text-muted mb-4">
                        {!! nl2br(e($partner->terms)) !!}
                    </div>
                @endif

                <!-- How to Avail -->
                @if($partner->how_to_avail)
                    <h5 class="fw-bold text-dark mt-4 mb-2"><i class="bi bi-check-circle text-success me-2"></i> How to Avail this Discount</h5>
                    <div class="p-3 bg-light rounded-3 small text-muted">
                        {!! nl2br(e($partner->how_to_avail)) !!}
                    </div>
                @endif
            </div>

            <!-- Brand & Course Applicability (Business Rule 7) -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                <h4 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check text-primary me-2"></i> Brand & Course Applicability</h4>
                <p class="text-muted small mb-3">
                    In accordance with institutional governance and franchisor agreements, this discount applies specifically to:
                </p>

                <div class="mb-4">
                    <strong class="d-block text-dark small mb-2">Applicable Brands:</strong>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($partner->brands as $brand)
                            <x-brand-badge :brand="$brand" class="fs-6 px-3 py-2" />
                        @empty
                            <span class="badge bg-secondary-subtle text-secondary border">Applicability determined per admission counseling.</span>
                        @endforelse
                    </div>
                </div>

                @if($partner->courses->isNotEmpty())
                    <div>
                        <strong class="d-block text-dark small mb-2">Specific Eligible Programmes:</strong>
                        <div class="row g-2">
                            @foreach($partner->courses as $c)
                                <div class="col-md-6">
                                    <div class="p-2 bg-light rounded border small d-flex justify-content-between align-items-center">
                                        <span>{{ $c->title }}</span>
                                        <a href="{{ route('courses.show', $c->slug) }}" class="btn btn-sm btn-link text-decoration-none">View Course</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar: Pre-filled Discount Claim Form & Fast WhatsApp -->
        <div class="col-lg-4">
            <!-- Validity Meta Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-calendar-check text-primary me-2"></i> Partnership Meta</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small mb-4">
                    @if($partner->signed_on)
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Signed On:</span>
                            <span class="fw-semibold">{{ $partner->signed_on->format('M d, Y') }}</span>
                        </li>
                    @endif
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">Valid Until:</span>
                        <span class="fw-semibold {{ $partner->valid_until && $partner->valid_until->isPast() ? 'text-danger' : 'text-success' }}">
                            {{ $partner->valid_until ? $partner->valid_until->format('M d, Y') : 'Active / Continuous' }}
                        </span>
                    </li>
                    @if($partner->website_url)
                        <li class="pt-2 border-top">
                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" class="text-decoration-none small text-primary fw-semibold">
                                Visit Partner Website <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        </li>
                    @endif
                </ul>

                @php
                    $whatsappMsg = urlencode("Hello F.S. Education, I am affiliated with {$partner->name} and would like to claim the agreed discount (Referral Code: {$partner->referral_code}) for admission.");
                @endphp
                @if(setting('whatsapp'))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp')) }}?text={{ $whatsappMsg }}"
                       target="_blank" rel="noopener" class="btn btn-success btn-sm w-100 fw-semibold">
                        <i class="bi bi-whatsapp me-1"></i> Claim Discount on WhatsApp
                    </a>
                @endif
            </div>

            <!-- Discount Claim Inquiry Form -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
                <h5 class="fw-bold text-dark mb-2"><i class="bi bi-ticket-perforated text-primary me-2"></i> Claim This Discount</h5>
                <p class="text-muted small mb-3">Submit your details to verify eligibility and apply your subsidy towards upcoming batches.</p>

                @if(session('success'))
                    <div class="alert alert-success small mb-3">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('inquiries.submit') }}" method="POST">
                    @csrf
                    {{-- Honeypot anti-spam --}}
                    <input type="text" name="website_hp" value="" style="display: none !important;" tabindex="-1" autocomplete="off">
                    <input type="hidden" name="mou_partner_id" value="{{ $partner->id }}">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Your Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" required value="{{ old('name') }}" placeholder="e.g. Bilal Tariq">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Phone / WhatsApp Number <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control form-control-sm" required value="{{ old('phone') }}" placeholder="e.g. 0300-1234567">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email Address (Optional)</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" placeholder="e.g. bilal@example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Referral Code</label>
                        <input type="text" name="referral_code_entered" class="form-control form-control-sm bg-white" value="{{ old('referral_code_entered', $partner->referral_code) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Preferred Campus Location</label>
                        <select name="centre_id" class="form-select form-select-sm">
                            <option value="">-- Choose Centre --</option>
                            @foreach($applicableCentres as $centre)
                                <option value="{{ $centre->id }}" {{ old('centre_id') == $centre->id ? 'selected' : '' }}>{{ $centre->name }} ({{ $centre->area }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Programme of Interest</label>
                        <select name="course_id" class="form-select form-select-sm">
                            <option value="">-- Choose Programme --</option>
                            @foreach($applicableCourses as $c)
                                <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Message / Affiliation Details</label>
                        <textarea name="message" class="form-control form-control-sm" rows="3" placeholder="Mention your student ID, employee card, or membership number...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                        Verify & Claim Discount <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
