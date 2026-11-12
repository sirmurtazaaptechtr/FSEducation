@extends('layouts.public')

@section('meta_title', setting('meta_title', setting('company_name', 'F.S. Education') . ' | Educational Network & Franchises in Karachi'))
@section('meta_description', setting('meta_description', 'F.S. Education is a premier educational group in Karachi operating accredited vocational programmes alongside Aptech and Arena Multimedia franchises.'))

@section('meta_tags')
    <x-meta-tags
        :title="setting('meta_title', setting('company_name', 'F.S. Education'))"
        :description="setting('meta_description')"
        :image="setting('default_og_image')"
    />
@endsection

@section('content')

{{-- SECTION 1: Hero Banner Carousel --}}
<section class="hero-section position-relative bg-dark text-white">
    @if($banners->isNotEmpty())
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-indicators">
                @foreach($banners as $index => $banner)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="min-height: 520px; max-height: 620px;">
                        @if($banner->image)
                            <img src="{{ asset('storage/' . $banner->image) }}" class="d-block w-100 h-100 object-fit-cover" alt="{{ $banner->title }}" style="filter: brightness(0.4);">
                        @else
                            <div class="w-100 h-100 bg-fs-navy" style="min-height: 520px;"></div>
                        @endif
                        <div class="carousel-caption text-start d-flex flex-column justify-content-center h-100 top-0 bottom-0 start-0 end-0 container">
                            <div class="col-lg-8 col-md-10">
                                <span class="badge bg-fs-gold text-dark text-uppercase px-3 py-2 mb-3 fw-bold letter-spacing-1">
                                    {{ setting('tagline', 'Learn Today. Lead Tomorrow.') }}
                                </span>
                                <h1 class="display-4 fw-bold text-white mb-3 text-shadow">{{ $banner->title }}</h1>
                                @if($banner->subtitle)
                                    <p class="lead text-white-50 mb-4 fs-5">{{ $banner->subtitle }}</p>
                                @endif
                                <div class="d-flex flex-wrap gap-3">
                                    @if($banner->button_text && $banner->button_url)
                                        <a href="{{ $banner->button_url }}" class="btn btn-warning btn-lg fw-bold px-4 shadow">
                                            {{ $banner->button_text }} <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    @endif
                                    <a href="{{ url('/courses') }}" class="btn btn-outline-light btn-lg px-4">
                                        Explore All Programmes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-label="Previous"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-label="Next"></span>
            </button>
        </div>
    @else
        <div class="bg-fs-navy py-5 text-white text-center">
            <div class="container py-5">
                <span class="badge bg-fs-gold text-dark text-uppercase px-3 py-2 mb-3 fw-bold">
                    {{ setting('tagline', 'Learn Today. Lead Tomorrow.') }}
                </span>
                <h1 class="display-4 fw-bold mb-3">{{ setting('company_name', 'F.S. Education') }}</h1>
                <p class="lead text-white-50 max-w-700 mx-auto mb-4">
                    {{ setting('intro', 'A growing educational network committed to empowering individuals through quality education, professional training and industry-relevant skills.') }}
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ url('/courses') }}" class="btn btn-warning btn-lg fw-bold px-4">Browse Programmes</a>
                    <a href="{{ url('/centres') }}" class="btn btn-outline-light btn-lg px-4">Our 5 Centres</a>
                </div>
            </div>
        </div>
    @endif
</section>

{{-- SECTION 2: "Who We Are" Group Introduction, Vision and Mission --}}
<section class="py-5 bg-white border-bottom">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="pe-lg-3">
                    <span class="text-uppercase text-fs-gold fw-bold small letter-spacing-1 d-block mb-2">About F.S. Education</span>
                    <h2 class="display-6 fw-bold text-fs-navy mb-4">Transforming Potential Into Professional Success</h2>
                    <p class="text-secondary lead fs-6 mb-4">
                        {{ setting('intro', 'F.S. Education is a growing educational network committed to empowering individuals through quality education, professional training and industry-relevant skills across Karachi.') }}
                    </p>
                    <div class="border-start border-4 border-primary ps-3 my-4">
                        <h6 class="fw-bold text-dark mb-1">Our Mission</h6>
                        <p class="text-muted small mb-0">{{ setting('mission', 'To make quality, practical and career-oriented education accessible to aspiring learners.') }}</p>
                    </div>
                    <div class="border-start border-4 border-warning ps-3 my-4">
                        <h6 class="fw-bold text-dark mb-1">Our Vision</h6>
                        <p class="text-muted small mb-0">{{ setting('vision', 'To become a leading educational network that transforms potential into professional success.') }}</p>
                    </div>
                    <div class="d-flex gap-3 pt-2">
                        <a href="{{ url('/about') }}" class="btn btn-outline-primary fw-semibold px-4">Learn More About Group</a>
                        <a href="{{ url('/accreditations') }}" class="btn btn-outline-secondary fw-semibold px-4">Affiliations & Registrations</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="bg-fs-navy p-4 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="fw-bold mb-0">Our Dynamic Network</h4>
                            <span class="badge bg-fs-gold text-dark fw-bold">5 Campuses</span>
                        </div>
                        <p class="text-white-50 small mb-0">
                            F.S. Education operates five dedicated centres across prime locations in Karachi, blending our own government-affiliated programmes with world-renowned franchise tracks.
                        </p>
                    </div>
                    <div class="card-body p-4 bg-light">
                        <div class="d-flex flex-column gap-3">
                            <div class="p-3 bg-white rounded-3 shadow-sm border-start border-4 border-fs-navy d-flex align-items-center justify-content-between">
                                <div>
                                    <strong class="text-dark d-block">F.S. Education Main Campus</strong>
                                    <small class="text-muted">Proprietary Programmes & SBTE / NAVTTC External Affiliations</small>
                                </div>
                                <span class="badge badge-brand-fs">F.S. Brand</span>
                            </div>
                            <div class="p-3 bg-white rounded-3 shadow-sm border-start border-4 border-danger d-flex align-items-center justify-content-between">
                                <div>
                                    <strong class="text-dark d-block">Aptech Computer Education</strong>
                                    <small class="text-muted">2 Franchise Centres (Shahrah-e-Faisal & North Nazimabad)</small>
                                </div>
                                <span class="badge badge-brand-aptech">Aptech</span>
                            </div>
                            <div class="p-3 bg-white rounded-3 shadow-sm border-start border-4 border-warning d-flex align-items-center justify-content-between">
                                <div>
                                    <strong class="text-dark d-block">Arena Multimedia</strong>
                                    <small class="text-muted">2 Franchise Centres (Gulshan-e-Iqbal & Clifton)</small>
                                </div>
                                <span class="badge badge-brand-arena">Arena</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION 3: Key Figures Counters (from stats table) --}}
@if($stats->isNotEmpty())
<section class="py-5 bg-fs-navy text-white">
    <div class="container py-3">
        <div class="row g-4 text-center">
            @foreach($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="p-3">
                        @if($stat->icon)
                            <div class="fs-2 text-fs-gold mb-2"><i class="{{ $stat->icon }}"></i></div>
                        @endif
                        <div class="display-5 fw-bold text-white mb-1">
                            <span class="stat-counter" data-value="{{ $stat->value }}">{{ $stat->value }}</span>{{ $stat->suffix }}
                        </div>
                        <div class="text-white-50 text-uppercase small letter-spacing-1 fw-semibold">{{ $stat->label }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SECTION 4: "Our Network" Centres Grouped by Brand --}}
<section class="py-5 bg-light border-bottom">
    <div class="container py-4">
        <div class="text-center mb-5 max-w-700 mx-auto">
            <span class="text-uppercase text-primary fw-bold small letter-spacing-1 d-block mb-2">Our Locations</span>
            <h2 class="display-6 fw-bold text-dark">Five Premier Centres Across Karachi</h2>
            <p class="text-muted">
                Each centre is equipped with certified master trainers, cutting-edge computing laboratories, and dedicated student placement advisory.
            </p>
        </div>

        <div class="row g-4">
            @foreach($brands as $brand)
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white p-4 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div class="d-flex align-items-center gap-3">
                                @if($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="height: 38px; object-fit: contain;">
                                @endif
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $brand->name }}</h4>
                                    <small class="text-muted">{{ $brand->description }}</small>
                                </div>
                            </div>
                            <x-brand-badge :brand="$brand" />
                        </div>
                        <div class="card-body p-4 bg-light">
                            <div class="row g-4">
                                @forelse($brand->centres as $centre)
                                    <div class="col-md-6 col-lg-4">
                                        <x-centre-card :centre="$centre" />
                                    </div>
                                @empty
                                    <div class="col-12 text-center text-muted py-3">
                                        No campuses active under this brand currently.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-3">
            <a href="{{ url('/network') }}" class="btn btn-outline-primary px-4 fw-semibold">
                Explore Full Network Directory <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- SECTION 5: Featured Courses --}}
@if($featuredCourses->isNotEmpty())
<section class="py-5 bg-white border-bottom">
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase text-primary fw-bold small letter-spacing-1 d-block mb-1">In-Demand Skills</span>
                <h2 class="display-6 fw-bold text-dark mb-0">Featured Programmes & Courses</h2>
            </div>
            <a href="{{ url('/courses') }}" class="btn btn-primary fw-semibold mt-2 mt-md-0">
                View All Courses <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredCourses as $course)
                <div class="col-md-6 col-lg-4 course-col">
                    <x-course-card :course="$course" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SECTION 6: "Our Partners and MOUs" Strip (Featured Only) --}}
@if($featuredMous->isNotEmpty())
<section class="py-5 bg-light border-bottom">
    <div class="container py-4">
        <div class="text-center mb-5 max-w-700 mx-auto">
            <span class="badge bg-warning text-dark text-uppercase px-3 py-2 mb-2 fw-bold">Exclusive Student Subsidies</span>
            <h2 class="display-6 fw-bold text-dark">Institutional MOU Partnerships</h2>
            <p class="text-muted">
                Through official Memorandums of Understanding with respected organizations, corporate employees, students, and members receive verified tuition discounts.
            </p>
        </div>

        <div class="row g-4">
            @foreach($featuredMous as $mou)
                <div class="col-md-6 col-lg-3">
                    <x-mou-card :partner="$mou" />
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/mou-partners') }}" class="btn btn-outline-primary fw-semibold px-4">
                View All Active MOU Partners & Discounts <i class="bi bi-arrow-right ms-1"></i>
            </a>
            <a href="{{ url('/become-a-partner') }}" class="btn btn-outline-dark fw-semibold px-4 ms-2">
                Sign an MOU with Us
            </a>
        </div>
    </div>
</section>
@endif

{{-- SECTION 7: Why Choose Us --}}
<section class="py-5 bg-white border-bottom">
    <div class="container py-4">
        <div class="text-center mb-5 max-w-700 mx-auto">
            <span class="text-uppercase text-primary fw-bold small letter-spacing-1 d-block mb-2">Our Advantage</span>
            <h2 class="display-6 fw-bold text-dark">Why Choose F.S. Education?</h2>
            <p class="text-muted">
                We combine industry-standard labs, certified master faculty, verified statutory affiliations, and practical career outcomes.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 h-100 border hover-shadow">
                    <div class="fs-1 text-primary mb-3"><i class="bi bi-award"></i></div>
                    <h5 class="fw-bold text-dark">Accredited & Franchise Options</h5>
                    <p class="text-muted small mb-0">
                        Select between government-affiliated diplomas (SBTE/NAVTTC) under F.S. Education or globally recognized certifications under Aptech and Arena franchises.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 h-100 border hover-shadow">
                    <div class="fs-1 text-warning mb-3"><i class="bi bi-pc-display-horizontal"></i></div>
                    <h5 class="fw-bold text-dark">High-Tech Computing Labs</h5>
                    <p class="text-muted small mb-0">
                        Modern multi-seat computing facilities equipped with professional software suites, high-speed fiber internet, and uninterrupted power backup.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-4 h-100 border hover-shadow">
                    <div class="fs-1 text-success mb-3"><i class="bi bi-briefcase"></i></div>
                    <h5 class="fw-bold text-dark">Internships & Career Placement</h5>
                    <p class="text-muted small mb-0">
                        Dedicated career placement assistance, portfolio reviews, and direct corporate recruitment pipelines for top-performing graduates.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION 8: Accreditations & Affiliations --}}
<section class="py-5 bg-light border-bottom">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="text-uppercase text-primary fw-bold small letter-spacing-1 d-block mb-2">Institutional Credibility</span>
                <h2 class="display-6 fw-bold text-dark mb-4">Official Affiliations & Registrations</h2>
                <p class="text-muted mb-4">
                    {{ setting('registration_statement', 'The network operates through institutions registered with relevant education and skills-development authorities, including SBTE and NAVTTC, subject to the respective centre and approved programme registrations.') }}
                </p>

                <div class="alert alert-warning border-warning small">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Statutory Transparency:</strong> Registration and approval claims apply per centre and per approved programme. Aptech and Arena Multimedia operate strictly under their respective international franchise charters.
                </div>

                <a href="{{ url('/accreditations') }}" class="btn btn-primary fw-semibold px-4">
                    Explore Affiliated Programmes <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="col-lg-6">
                <div class="row g-4">
                    @foreach($affiliations as $affiliation)
                        <div class="col-sm-6">
                            <div class="card h-100 border-0 shadow-sm p-4 bg-white text-center">
                                @if($affiliation->logo)
                                    <img src="{{ asset('storage/' . $affiliation->logo) }}" alt="{{ $affiliation->name }}" class="mx-auto mb-3" style="height: 60px; object-fit: contain;">
                                @else
                                    <div class="mx-auto mb-3 text-primary fs-1"><i class="bi bi-patch-check"></i></div>
                                @endif
                                <h5 class="fw-bold text-dark mb-1">{{ $affiliation->short_name }}</h5>
                                <small class="text-muted d-block mb-3">{{ $affiliation->name }}</small>
                                <p class="text-muted small mb-0">{{ Str::limit($affiliation->description, 90) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION 9: Latest News --}}
@if($latestNews->isNotEmpty())
<section class="py-5 bg-white border-bottom">
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase text-primary fw-bold small letter-spacing-1 d-block mb-1">Updates</span>
                <h2 class="display-6 fw-bold text-dark mb-0">Latest News & Events</h2>
            </div>
            <a href="{{ url('/news') }}" class="btn btn-outline-primary fw-semibold mt-2 mt-md-0">
                All News Articles <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($latestNews as $post)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        @if($post->image)
                            <div style="height: 180px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover">
                            </div>
                        @endif
                        <div class="card-body p-4 d-flex flex-column">
                            <small class="text-muted mb-2"><i class="bi bi-calendar3 me-1"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</small>
                            <h5 class="fw-bold text-dark mb-2">{{ $post->title }}</h5>
                            <p class="text-muted small mb-3 flex-grow-1">{{ $post->excerpt }}</p>
                            <a href="{{ url('/news/' . $post->slug) }}" class="text-primary fw-semibold text-decoration-none small">
                                Read Full Story <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SECTION 10: Testimonials --}}
@if($testimonials->isNotEmpty())
<section class="py-5 bg-light border-bottom">
    <div class="container py-4">
        <div class="text-center mb-5 max-w-700 mx-auto">
            <span class="text-uppercase text-primary fw-bold small letter-spacing-1 d-block mb-2">Student Stories</span>
            <h2 class="display-6 fw-bold text-dark">What Our Students & Alumni Say</h2>
            <p class="text-muted">Real experiences from students who launched rewarding careers through F.S. Education centres.</p>
        </div>

        <div class="row g-4">
            @foreach($testimonials as $t)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 bg-white d-flex flex-column">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted fst-italic flex-grow-1 mb-4">"{{ $t->quote }}"</p>
                        <div class="d-flex align-items-center gap-3 pt-3 border-top">
                            @if($t->photo)
                                <img src="{{ asset('storage/' . $t->photo) }}" alt="{{ $t->name }}" class="rounded-circle object-fit-cover" style="width: 48px; height: 48px;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 48px; height: 48px;">
                                    {{ substr($t->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <strong class="text-dark d-block">{{ $t->name }}</strong>
                                <small class="text-muted">{{ $t->role_or_course }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SECTION 11: Call to Action --}}
<section class="py-5 bg-fs-navy text-white text-center position-relative">
    <div class="container py-4">
        <div class="col-lg-8 mx-auto">
            <span class="badge bg-fs-gold text-dark text-uppercase px-3 py-2 mb-3 fw-bold letter-spacing-1">
                Admissions Open
            </span>
            <h2 class="display-5 fw-bold mb-3">Begin Your Professional Journey Today</h2>
            <p class="lead text-white-50 mb-4">
                Connect with our academic advisors to select the right programme, claim available partner MOU discounts, and secure your admission at our nearest campus.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ url('/contact#inquiry-form') }}" class="btn btn-warning btn-lg fw-bold px-4 shadow">
                    Apply for Admission Now
                </a>
                <a href="{{ url('/centres') }}" class="btn btn-outline-light btn-lg px-4">
                    Find Nearest Centre
                </a>
                @if(setting('whatsapp'))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp')) }}?text={{ urlencode('Hello, I want to inquire about admissions at F.S. Education.') }}"
                       target="_blank" rel="noopener"
                       class="btn btn-success btn-lg px-4">
                        <i class="bi bi-whatsapp me-2"></i> Chat with Admissions
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
