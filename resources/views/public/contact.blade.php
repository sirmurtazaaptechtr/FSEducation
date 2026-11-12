@extends('layouts.public')

@section('meta_title', 'Contact Us & Campus Admissions | F.S. Education Karachi')
@section('meta_description', 'Get in touch with F.S. Education central office and find direct phone, WhatsApp and address details for all five centres across Karachi.')

@section('meta_tags')
    <x-meta-tags
        title="Contact Us & Campus Admissions"
        description="Get in touch with F.S. Education central office and find direct phone, WhatsApp and address details for all five centres across Karachi."
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Contact Us</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">Contact Admissions & Network Centres</h1>
        <p class="lead text-white-50 mb-0">We are here to answer your questions regarding admissions, batch timings, and MOU discounts</p>
    </div>
</div>

<div class="container py-5">
    <!-- Fast Central Contact Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-light text-center">
                <div class="fs-1 text-primary mb-2"><i class="bi bi-telephone"></i></div>
                <h5 class="fw-bold text-dark">Phone Inquiries</h5>
                <p class="text-muted small mb-2">Speak directly with our central admissions desk:</p>
                <a href="tel:{{ setting('phone', '+92 21 34567890') }}" class="fw-bold text-primary fs-5 text-decoration-none">
                    {{ setting('phone', '+92 21 34567890') }}
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-light text-center">
                <div class="fs-1 text-success mb-2"><i class="bi bi-whatsapp"></i></div>
                <h5 class="fw-bold text-dark">WhatsApp Admissions</h5>
                <p class="text-muted small mb-2">Quick answers via WhatsApp chat:</p>
                @if(setting('whatsapp'))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp')) }}?text={{ urlencode('Hello F.S. Education admissions, I have an inquiry.') }}"
                       target="_blank" rel="noopener" class="fw-bold text-success fs-5 text-decoration-none">
                        {{ setting('whatsapp') }}
                    </a>
                @else
                    <span class="text-muted">Chat available via phone</span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-light text-center">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-envelope"></i></div>
                <h5 class="fw-bold text-dark">Email Inquiries</h5>
                <p class="text-muted small mb-2">Send us your documentation or official requests:</p>
                <a href="mailto:{{ setting('email', 'info@fseducation.pk') }}" class="fw-bold text-dark fs-6 text-decoration-none">
                    {{ setting('email', 'info@fseducation.pk') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Inquiry Form & Network Directory -->
    <div class="row g-5">
        <!-- Inquiry Form -->
        <div class="col-lg-6" id="inquiry-form">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <h3 class="fw-bold text-dark mb-2"><i class="bi bi-send text-primary me-2"></i> Send an Inquiry</h3>
                <p class="text-muted small mb-4">Complete this form and an academic counselor will contact you with fee structures and schedule details.</p>

                @if(session('success'))
                    <div class="alert alert-success small mb-4">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger small mb-4">
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

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Your Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="e.g. Muhammad Zeeshan">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Phone / WhatsApp Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" required value="{{ old('phone') }}" placeholder="e.g. 0300-1234567">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Email (Optional)</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. zeeshan@example.com">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Preferred Campus Location</label>
                            <select name="centre_id" class="form-select">
                                <option value="">-- Choose Centre --</option>
                                @foreach($centres as $c)
                                    <option value="{{ $c->id }}" {{ old('centre_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }} ({{ $c->area }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Programme of Interest</label>
                            <select name="course_id" class="form-select">
                                <option value="">-- Choose Programme --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }} ({{ $course->brand?->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">MOU Partner Referral (if any)</label>
                            <select name="mou_partner_id" class="form-select">
                                <option value="">-- None / Standard Admission --</option>
                                @foreach($mouPartners as $mp)
                                    <option value="{{ $mp->id }}" {{ old('mou_partner_id') == $mp->id ? 'selected' : '' }}>
                                        {{ $mp->name }} ({{ $mp->discount_label }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Referral Code (if any)</label>
                            <input type="text" name="referral_code_entered" class="form-control" value="{{ old('referral_code_entered') }}" placeholder="e.g. PARTNER2026">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Your Message or Inquiry</label>
                        <textarea name="message" class="form-control" rows="3" placeholder="Preferred timing (morning/afternoon/weekend), prior background, or specific questions...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold w-100 py-2">
                        Submit Admission Inquiry <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Campus Network Directory -->
        <div class="col-lg-6">
            <h4 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt text-primary me-2"></i> Our Five Campuses</h4>
            <p class="text-muted small mb-4">Visit any of our five campuses during working hours (Monday to Saturday, 9:00 AM – 8:00 PM).</p>

            <div class="d-flex flex-column gap-3">
                @foreach($centres as $c)
                    <div class="p-3 bg-white rounded-4 shadow-sm border hover-shadow">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold text-dark mb-0">{{ $c->name }}</h6>
                                <small class="text-muted"><i class="bi bi-geo-alt text-primary me-1"></i> {{ $c->address ?: $c->area . ', ' . $c->city }}</small>
                            </div>
                            <x-brand-badge :brand="$c->brand" />
                        </div>
                        <div class="d-flex flex-wrap gap-3 small pt-2 border-top">
                            @if($c->phone)
                                <a href="tel:{{ $c->phone }}" class="text-decoration-none text-muted">
                                    <i class="bi bi-telephone text-primary me-1"></i> {{ $c->phone }}
                                </a>
                            @endif
                            @if($c->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c->whatsapp) }}?text={{ urlencode('Hello, inquiring about ' . $c->name) }}"
                                   target="_blank" rel="noopener" class="text-decoration-none text-success fw-medium">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            @endif
                            @if($c->map_url)
                                <a href="{{ $c->map_url }}" target="_blank" rel="noopener" class="text-decoration-none text-primary ms-auto fw-medium">
                                    <i class="bi bi-map me-1"></i> Map Directions
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

