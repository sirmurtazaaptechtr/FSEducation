@extends('layouts.public')

@section('meta_title', $course->title . ' | F.S. Education Network')
@section('meta_description', Str::limit($course->short_description ?: $course->description, 160))

@section('meta_tags')
    <x-meta-tags
        :title="$course->title"
        :description="$course->short_description ?: $course->description"
        :image="$course->image"
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/courses') }}" class="text-white-50 text-decoration-none">Courses</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">{{ $course->title }}</li>
            </ol>
        </nav>
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <x-brand-badge :brand="$course->brand" class="fs-6 px-3 py-1" />
                    @if($course->category)
                        <span class="badge bg-secondary">{{ $course->category->name }}</span>
                    @endif
                    @if($course->brand?->slug === 'fs-education' && $course->affiliation)
                        <span class="badge bg-info text-dark"><i class="bi bi-award me-1"></i> {{ $course->affiliation->short_name }} Affiliated</span>
                    @endif
                    @if($course->approval_status === 'approved')
                        <span class="badge bg-success"><i class="bi bi-patch-check-fill me-1"></i> Approved Programme</span>
                    @endif
                </div>
                <h1 class="display-5 fw-bold mb-1">{{ $course->title }}</h1>
            </div>
            <div>
                <x-share-buttons :title="$course->title" />
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <!-- Course Hero Image -->
            @if($course->image)
                <div class="rounded-4 overflow-hidden shadow-sm mb-4" style="max-height: 420px;">
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-100 h-100 object-fit-cover">
                </div>
            @endif

            <!-- Key Course Parameters Ribbon -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light mb-4">
                <div class="row g-3 text-center">
                    <div class="col-sm-4 border-end-sm">
                        <small class="text-muted text-uppercase fw-semibold d-block">Duration</small>
                        <span class="fw-bold fs-5 text-dark"><i class="bi bi-clock text-primary me-1"></i> {{ $course->duration ?: 'Contact Centre' }}</span>
                    </div>
                    <div class="col-sm-4 border-end-sm">
                        <small class="text-muted text-uppercase fw-semibold d-block">Eligibility</small>
                        <span class="fw-bold fs-5 text-dark"><i class="bi bi-mortarboard text-primary me-1"></i> {{ $course->eligibility ?: 'Open Admission' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted text-uppercase fw-semibold d-block">Tuition / Fee</small>
                        <span class="fw-bold fs-5 text-dark"><i class="bi bi-cash-stack text-success me-1"></i> {{ $course->fee_note ?: 'Subsidies Available' }}</span>
                    </div>
                </div>
            </div>

            <!-- Statutory & Accreditation Transparency Banner (Business Rules 4 & 5) -->
            @if($course->brand?->slug === 'fs-education' && ($course->affiliation || $course->approval_status === 'approved'))
                <div class="card border-info border-opacity-25 bg-info bg-opacity-10 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-2"><i class="bi bi-shield-check text-info me-2"></i> Institutional Registration & Approval Details</h5>
                    <p class="text-muted small mb-2">
                        This programme is offered directly under <strong>F.S. Education</strong> and complies with official skills council guidelines:
                    </p>
                    <ul class="list-unstyled small mb-0 d-flex flex-column gap-1">
                        @if($course->affiliation)
                            <li><strong>Governing Body:</strong> {{ $course->affiliation->name }} ({{ $course->affiliation->short_name }})</li>
                        @endif
                        @if($course->registration_reference)
                            <li><strong>Registration / Approval Ref:</strong> <span class="font-monospace text-dark fw-bold">{{ $course->registration_reference }}</span></li>
                        @endif
                        @if($course->approval_note)
                            <li><strong>Approval Scope:</strong> {{ $course->approval_note }}</li>
                        @endif
                    </ul>
                </div>
            @elseif(in_array($course->brand?->slug, ['aptech', 'arena-multimedia']))
                <div class="franchise-guideline-box mb-4">
                    <i class="bi bi-award me-2 fs-5"></i>
                    <strong>Franchise Certification Track:</strong> This curriculum is governed under the global academic standards of {{ $course->brand->name }}. Course completion leads to internationally recognized franchise certificates.
                </div>
            @endif

            <!-- Description -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                <h4 class="fw-bold text-dark mb-3">Programme Overview</h4>
                <div class="text-secondary lead fs-6 mb-4">
                    {!! nl2br(e($course->description ?: $course->short_description)) !!}
                </div>

                @if($course->outcomes)
                    <h5 class="fw-bold text-dark mt-4 mb-3"><i class="bi bi-check2-circle text-success me-2"></i> Key Learning Outcomes & Career Skills</h5>
                    <div class="p-3 bg-light rounded-3 small">
                        {!! nl2br(e($course->outcomes)) !!}
                    </div>
                @endif
            </div>

            <!-- Applicable MOU Discounts Alert Box -->
            @if($applicableMous->isNotEmpty())
                <div class="card border-warning border-opacity-50 bg-warning bg-opacity-10 shadow-sm rounded-4 p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-percent text-warning me-2"></i> Partner Subsidies Available for this Course</h5>
                        <span class="badge bg-warning text-dark">{{ $applicableMous->count() }} Partner MOUs</span>
                    </div>
                    <p class="text-muted small mb-3">
                        Are you a student, employee, or member of one of our MOU partner institutions? You may be eligible for agreed tuition discounts on this programme:
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($applicableMous as $mou)
                            <a href="{{ route('mou-partners.show', $mou->slug) }}" class="btn btn-sm btn-outline-dark bg-white">
                                <strong>{{ $mou->name }}</strong> ({{ $mou->discount_label }})
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Campuses offering this course -->
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                <h4 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt text-primary me-2"></i> Offered at These Centres</h4>
                <div class="row g-3">
                    @forelse($course->centres as $centre)
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="text-dark d-block">{{ $centre->name }}</strong>
                                    <small class="text-muted">{{ $centre->area }}, {{ $centre->city }}</small>
                                </div>
                                <a href="{{ route('centres.show', $centre->slug) }}" class="btn btn-outline-primary btn-sm">
                                    Campus Details <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-muted small">Please contact central admissions for campus assignments.</div>
                    @endforelse
                </div>
            </div>

            <!-- Related Programmes -->
            @if($relatedCourses->isNotEmpty())
                <div class="mb-4">
                    <h4 class="fw-bold text-dark mb-3">Related Programmes from {{ $course->brand?->name }}</h4>
                    <div class="row g-3">
                        @foreach($relatedCourses as $rel)
                            <div class="col-md-4 course-col">
                                <x-course-card :course="$rel" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar: Admission Inquiry Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 90px;">
                <h5 class="fw-bold text-dark mb-2"><i class="bi bi-send text-primary me-2"></i> Enroll in this Course</h5>
                <p class="text-muted small mb-3">Fill out this quick form to reserve a counseling seat or request fee schedule.</p>

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
                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Your Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" required value="{{ old('name') }}" placeholder="e.g. Sara Khan">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Phone / WhatsApp Number <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control form-control-sm" required value="{{ old('phone') }}" placeholder="e.g. 0300-1234567">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email Address (Optional)</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" placeholder="e.g. sara@example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Preferred Campus Location</label>
                        <select name="centre_id" class="form-select form-select-sm">
                            <option value="">-- Choose Nearest Centre --</option>
                            @foreach($course->centres as $c)
                                <option value="{{ $c->id }}" {{ old('centre_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->area }})</option>
                            @endforeach
                        </select>
                    </div>

                    @if($applicableMous->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">MOU Partner Referral (Optional)</label>
                            <select name="mou_partner_id" class="form-select form-select-sm">
                                <option value="">-- No MOU / Standard Admission --</option>
                                @foreach($applicableMous as $mp)
                                    <option value="{{ $mp->id }}" {{ old('mou_partner_id') == $mp->id ? 'selected' : '' }}>{{ $mp->name }} ({{ $mp->discount_label }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Referral Code</label>
                            <input type="text" name="referral_code_entered" class="form-control form-control-sm" value="{{ old('referral_code_entered') }}" placeholder="Partner code (if applicable)">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Questions or Notes</label>
                        <textarea name="message" class="form-control form-control-sm" rows="3" placeholder="Preferred morning/evening batch, weekend schedule...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                        Submit Enrollment Inquiry <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top text-center small text-muted">
                    <span>Need instant help?</span>
                    @if(setting('whatsapp'))
                        <div class="mt-2">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp')) }}?text={{ urlencode('Hello, I am inquiring about the course: ' . $course->title) }}"
                               target="_blank" rel="noopener" class="text-success fw-semibold text-decoration-none">
                                <i class="bi bi-whatsapp me-1"></i> WhatsApp Admissions
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

