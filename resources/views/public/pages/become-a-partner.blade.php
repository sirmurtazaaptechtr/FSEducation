@extends('layouts.public')

@section('meta_title', 'Become an Institutional Partner | F.S. Education Network')
@section('meta_description', 'Sign an educational MOU with F.S. Education to provide guaranteed tuition discounts, vocational training, and career workshops for your students, employees, or members.')

@section('meta_tags')
    <x-meta-tags
        title="Institutional MOU Partnerships"
        description="Sign an educational MOU with F.S. Education to provide guaranteed tuition discounts, vocational training, and career workshops for your students, employees, or members."
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Become a Partner</li>
            </ol>
        </nav>
        <span class="badge bg-warning text-dark px-3 py-1 mb-2 fw-bold text-uppercase">Institutional Synergies</span>
        <h1 class="display-5 fw-bold mb-1">Partner with F.S. Education</h1>
        <p class="lead text-white-50 mb-0">Empower your students, employees, and community through bilateral training partnerships</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                <h3 class="fw-bold text-dark mb-3">Why Sign an MOU with Us?</h3>
                <p class="text-secondary lead fs-6 mb-4">
                    F.S. Education actively collaborates with high schools, intermediate colleges, degree universities, corporate firms, and community NGOs across Karachi to deliver tangible, market-ready career skills.
                </p>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="p-3 bg-light rounded-3 border-start border-4 border-primary">
                        <strong class="text-dark d-block mb-1"><i class="bi bi-percent text-primary me-1"></i> Agreed Tuition Subsidies</strong>
                        <span class="text-muted small">Your registered students, alumni, employees, and direct family members receive verified fee discounts across eligible certificate and diploma tracks.</span>
                    </div>
                    <div class="p-3 bg-light rounded-3 border-start border-4 border-warning">
                        <strong class="text-dark d-block mb-1"><i class="bi bi-mortarboard text-warning me-1"></i> Complimentary Masterclasses & Workshops</strong>
                        <span class="text-muted small">We conduct on-site and online hands-on sessions in AI tools, software engineering, digital media, and career readiness for your members.</span>
                    </div>
                    <div class="p-3 bg-light rounded-3 border-start border-4 border-success">
                        <strong class="text-dark d-block mb-1"><i class="bi bi-briefcase text-success me-1"></i> Career Advisory & Talent Pipeline</strong>
                        <span class="text-muted small">Direct recruitment access to trained, industry-certified graduates from our Aptech, Arena, and F.S. Education campuses.</span>
                    </div>
                </div>

                <div class="p-3 bg-fs-navy text-white rounded-3 small">
                    <i class="bi bi-shield-check me-2 text-warning fs-5"></i>
                    <strong>Formal Bilateral Memorandum:</strong> Partnerships are executed through clear, legally sound MOUs with no financial obligation on the partner institution.
                </div>
            </div>
        </div>

        <!-- Partnership Application Form -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <h4 class="fw-bold text-dark mb-2"><i class="bi bi-file-earmark-text text-primary me-2"></i> Request an MOU</h4>
                <p class="text-muted small mb-4">Complete this short inquiry and our Institutional Partnerships Director will connect with you.</p>

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

                <form action="{{ route('partner-request.submit') }}" method="POST">
                    @csrf
                    {{-- Honeypot anti-spam --}}
                    <input type="text" name="company_hp" value="" style="display: none !important;" tabindex="-1" autocomplete="off">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Organization / Institution Name <span class="text-danger">*</span></label>
                        <input type="text" name="organization_name" class="form-control" required value="{{ old('organization_name') }}" placeholder="e.g. City College Karachi">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Focal Contact Person <span class="text-danger">*</span></label>
                        <input type="text" name="contact_person" class="form-control" required value="{{ old('contact_person') }}" placeholder="e.g. Prof. Tariq Mahmood">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Contact Phone <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" required value="{{ old('phone') }}" placeholder="e.g. 0300-1234567">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Official Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="e.g. partnerships@college.edu">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Partnership Proposal / Note</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Briefly describe your student/employee strength and collaboration ideas...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold w-100 py-2">
                        Submit MOU Partnership Request <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
