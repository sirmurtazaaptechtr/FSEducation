@extends('layouts.public')

@section('meta_title', $centre->name . ' | F.S. Education Campus')
@section('meta_description', Str::limit($centre->short_description ?: $centre->description, 160))

@section('meta_tags')
    <x-meta-tags
        :title="$centre->name"
        :description="$centre->short_description ?: $centre->description"
        :image="$centre->cover_image"
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/centres') }}" class="text-white-50 text-decoration-none">Centres</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">{{ $centre->name }}</li>
            </ol>
        </nav>
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <x-brand-badge :brand="$centre->brand" class="fs-6 px-3 py-1" />
                    <span class="badge bg-secondary"><i class="bi bi-geo-alt me-1"></i> {{ $centre->area }}, {{ $centre->city }}</span>
                </div>
                <h1 class="display-5 fw-bold mb-1">{{ $centre->name }}</h1>
            </div>
            <div>
                <x-share-buttons :title="$centre->name" />
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <!-- Cover Image -->
            @if($centre->cover_image)
                <div class="rounded-4 overflow-hidden shadow-sm mb-4" style="max-height: 420px;">
                    <img src="{{ asset('storage/' . $centre->cover_image) }}" alt="{{ $centre->name }}" class="w-100 h-100 object-fit-cover">
                </div>
            @endif

            <!-- Franchise compliance note (if Aptech or Arena) -->
            @if(in_array($centre->brand?->slug, ['aptech', 'arena-multimedia']))
                <div class="franchise-guideline-box mb-4">
                    <i class="bi bi-shield-check me-2 fs-5"></i>
                    <strong>Franchise Center:</strong> This location operates under direct franchise authorization from {{ $centre->brand->name }}. Curriculum, technology tools, certifications, and academic delivery comply strictly with franchisor standards.
                </div>
            @endif

            <!-- Description -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                <h4 class="fw-bold text-dark mb-3">About this Campus</h4>
                <div class="text-secondary lead fs-6 mb-4">
                    {!! nl2br(e($centre->description ?: $centre->short_description)) !!}
                </div>

                @if($centre->registration_note)
                    <div class="p-3 bg-light border-start border-4 border-primary rounded-3 small">
                        <strong class="text-primary d-block mb-1"><i class="bi bi-award me-1"></i> Centre Registration & Affiliation Note:</strong>
                        <span class="text-muted">{{ $centre->registration_note }}</span>
                    </div>
                @endif
            </div>

            <!-- Campus Photo Gallery (Vanilla Lightbox) -->
            @if($centre->images->isNotEmpty())
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                    <h4 class="fw-bold text-dark mb-3"><i class="bi bi-images text-primary me-2"></i> Campus Facilities & Labs</h4>
                    <p class="text-muted small mb-4">Click any photo to view in high resolution.</p>
                    <div class="row g-3">
                        @foreach($centre->images as $img)
                            <div class="col-6 col-md-4">
                                <a href="{{ asset('storage/' . $img->path) }}"
                                   data-lightbox="campus-gallery"
                                   data-caption="{{ $img->caption ?: $centre->name }}"
                                   class="d-block rounded-3 overflow-hidden shadow-sm position-relative hover-shadow"
                                   style="height: 140px;">
                                    <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $img->alt_text ?: $centre->name }}" class="w-100 h-100 object-fit-cover">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Programmes Offered at this Centre -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-dark mb-0"><i class="bi bi-book text-primary me-2"></i> Programmes Offered Here</h4>
                    <span class="badge bg-primary">{{ $courses->count() }} Programmes</span>
                </div>

                @if($courses->isNotEmpty())
                    <div class="row g-3">
                        @foreach($courses as $course)
                            <div class="col-md-6 course-col">
                                <x-course-card :course="$course" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted small mb-0">Please contact admissions for batch schedules at this campus.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar: Contact Info & Inquiry Form -->
        <div class="col-lg-4">
            <!-- Campus Contact Card -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-building text-primary me-2"></i> Campus Contact</h5>
                <ul class="list-unstyled d-flex flex-column gap-3 small mb-4">
                    @if($centre->address)
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt text-primary fs-5"></i>
                            <div>
                                <strong class="text-dark d-block">Address</strong>
                                <span class="text-muted">{{ $centre->address }}</span>
                            </div>
                        </li>
                    @endif
                    @if($centre->phone)
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-telephone text-primary fs-5"></i>
                            <div>
                                <strong class="text-dark d-block">Phone</strong>
                                <a href="tel:{{ $centre->phone }}" class="text-decoration-none text-muted">{{ $centre->phone }}</a>
                            </div>
                        </li>
                    @endif
                    @if($centre->whatsapp)
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-whatsapp text-success fs-5"></i>
                            <div>
                                <strong class="text-dark d-block">WhatsApp</strong>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $centre->whatsapp) }}?text={{ urlencode('Hello, I want to inquire about ' . $centre->name) }}"
                                   target="_blank" rel="noopener" class="text-decoration-none text-success fw-semibold">
                                    {{ $centre->whatsapp }}
                                </a>
                            </div>
                        </li>
                    @endif
                    @if($centre->email)
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-envelope text-primary fs-5"></i>
                            <div>
                                <strong class="text-dark d-block">Email</strong>
                                <a href="mailto:{{ $centre->email }}" class="text-decoration-none text-muted">{{ $centre->email }}</a>
                            </div>
                        </li>
                    @endif
                </ul>

                @if($centre->map_url)
                    <a href="{{ $centre->map_url }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm w-100 fw-semibold mb-2">
                        <i class="bi bi-map me-1"></i> Open in Google Maps
                    </a>
                @endif
                @if($centre->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $centre->whatsapp) }}?text={{ urlencode('Hello, I am interested in admission at ' . $centre->name) }}"
                       target="_blank" rel="noopener" class="btn btn-success btn-sm w-100 fw-semibold">
                        <i class="bi bi-whatsapp me-1"></i> Chat Directly on WhatsApp
                    </a>
                @endif
            </div>

            <!-- Campus Inquiry Form -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light" id="inquiry-box">
                <h5 class="fw-bold text-dark mb-2"><i class="bi bi-send text-primary me-2"></i> Inquire at this Campus</h5>
                <p class="text-muted small mb-3">Submit your details to request fee structure, batch schedules, or scholarships.</p>

                @if(session('success'))
                    <div class="alert alert-success small mb-3">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger small mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('inquiries.submit') }}" method="POST">
                    @csrf
                    {{-- Honeypot anti-spam --}}
                    <input type="text" name="website_hp" value="" style="display: none !important;" tabindex="-1" autocomplete="off">
                    <input type="hidden" name="centre_id" value="{{ $centre->id }}">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Your Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" required value="{{ old('name') }}" placeholder="e.g. Ali Ahmed">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Phone / WhatsApp Number <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control form-control-sm" required value="{{ old('phone') }}" placeholder="e.g. 0300-1234567">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email Address (Optional)</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" placeholder="e.g. name@example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Programme of Interest</label>
                        <select name="course_id" class="form-select form-select-sm">
                            <option value="">-- Choose Programme --</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Referred by Partner Organization?</label>
                        <select name="mou_partner_id" class="form-select form-select-sm">
                            <option value="">-- None / General Inquiry --</option>
                            @foreach($mouPartners as $mp)
                                <option value="{{ $mp->id }}" {{ old('mou_partner_id') == $mp->id ? 'selected' : '' }}>{{ $mp->name }} ({{ $mp->discount_label }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Partner Referral Code (if any)</label>
                        <input type="text" name="referral_code_entered" class="form-control form-control-sm" value="{{ old('referral_code_entered') }}" placeholder="e.g. MOU2026">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Your Question / Message</label>
                        <textarea name="message" class="form-control form-control-sm" rows="3" placeholder="Tell us about your educational background or preferred timings...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                        Submit Campus Inquiry <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
