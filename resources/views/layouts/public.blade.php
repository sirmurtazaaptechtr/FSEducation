<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', setting('meta_title', setting('company_name', 'F.S. Education')))</title>
    <meta name="description" content="@yield('meta_description', setting('meta_description', 'F.S. Education is a premier education network in Karachi offering accredited programmes and global franchises.'))">
    @yield('meta_tags')

    <!-- Favicon -->
    @if(setting('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . setting('site_favicon')) }}">
    @endif

    <!-- Vite Styles & Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Top Utility Bar -->
    <div class="bg-fs-navy py-1 border-bottom border-secondary border-opacity-25 small text-white-50">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                @if(setting('phone'))
                    <span><i class="bi bi-telephone text-fs-gold me-1"></i> {{ setting('phone') }}</span>
                @endif
                @if(setting('email'))
                    <span class="d-none d-md-inline"><i class="bi bi-envelope text-fs-gold me-1"></i> {{ setting('email') }}</span>
                @endif
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="d-none d-sm-inline text-warning"><i class="bi bi-award me-1"></i> Registered Network Programmes</span>
                <div class="d-flex gap-2">
                    @if(setting('facebook_url'))<a href="{{ setting('facebook_url') }}" target="_blank" rel="noopener" class="text-white-50 hover-white"><i class="bi bi-facebook"></i></a>@endif
                    @if(setting('instagram_url'))<a href="{{ setting('instagram_url') }}" target="_blank" rel="noopener" class="text-white-50 hover-white"><i class="bi bi-instagram"></i></a>@endif
                    @if(setting('linkedin_url'))<a href="{{ setting('linkedin_url') }}" target="_blank" rel="noopener" class="text-white-50 hover-white"><i class="bi bi-linkedin"></i></a>@endif
                    @if(setting('youtube_url'))<a href="{{ setting('youtube_url') }}" target="_blank" rel="noopener" class="text-white-50 hover-white"><i class="bi bi-youtube"></i></a>@endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                @if(setting('site_logo'))
                    <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('company_name', 'F.S. Education') }}" height="48">
                @else
                    <div class="d-flex flex-column">
                        <span class="fw-bold fs-4 text-fs-navy lh-1">{{ setting('company_name', 'F.S. Education') }}</span>
                        <small class="text-muted text-uppercase letter-spacing-1 font-monospace" style="font-size: 0.65rem;">{{ setting('tagline', 'Learn Today. Lead Tomorrow.') }}</small>
                    </div>
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('about*') || request()->is('vision-mission') || request()->is('why-us') ? 'active fw-bold text-primary' : '' }}" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            About Group
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="aboutDropdown">
                            <li><a class="dropdown-item" href="{{ url('/about') }}">About F.S. Education</a></li>
                            <li><a class="dropdown-item" href="{{ url('/vision-mission') }}">Vision & Mission</a></li>
                            <li><a class="dropdown-item" href="{{ url('/why-us') }}">Why Choose Us</a></li>
                            <li><a class="dropdown-item" href="{{ url('/leadership-message') }}">Leadership Message</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('centres*') || request()->is('network*') ? 'active fw-bold text-primary' : '' }}" href="#" id="networkDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Our Network
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="networkDropdown">
                            <li><a class="dropdown-item fw-semibold text-primary" href="{{ url('/network') }}"><i class="bi bi-grid me-2"></i> All 5 Centres Overview</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header text-uppercase text-muted small">By Brand</h6></li>
                            <li><a class="dropdown-item" href="{{ url('/centres?brand=fs-education') }}"><span class="badge badge-brand-fs me-1">F.S.</span> F.S. Education Main Campus</a></li>
                            <li><a class="dropdown-item" href="{{ url('/centres?brand=aptech') }}"><span class="badge badge-brand-aptech me-1">Aptech</span> Aptech Centres (2)</a></li>
                            <li><a class="dropdown-item" href="{{ url('/centres?brand=arena-multimedia') }}"><span class="badge badge-brand-arena me-1">Arena</span> Arena Multimedia (2)</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('courses*') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/courses') }}">Programmes & Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('accreditations*') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/accreditations') }}">SBTE & NAVTTC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('mou-partners*') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/mou-partners') }}">
                            <span class="badge bg-warning text-dark me-1">Discounts</span> MOU Partners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('news*') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/news') }}">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact*') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/contact') }}">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-outline-primary btn-sm px-3" href="{{ url('/become-a-partner') }}">Partner With Us</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-primary btn-sm px-3" href="{{ url('/contact#inquiry-form') }}">Apply Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Floating WhatsApp CTA Button -->
    @if(setting('whatsapp'))
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp')) }}?text={{ urlencode('Hello F.S. Education, I would like to inquire about courses and admissions.') }}"
           class="whatsapp-float"
           target="_blank"
           rel="noopener"
           title="Chat on WhatsApp"
           aria-label="Chat with F.S. Education on WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
    @endif

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 border-top border-secondary border-opacity-25 mt-5">
        <div class="container">
            <div class="row g-4">
                <!-- Group Info -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-bold mb-3">{{ setting('company_name', 'F.S. Education') }}</h5>
                    <p class="text-white-50 small mb-3">
                        {{ setting('intro', 'F.S. Education is a growing educational network committed to empowering individuals through quality education, professional training and industry-relevant skills.') }}
                    </p>
                    <div class="p-3 bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded small text-white-50 mb-3">
                        <strong class="text-warning d-block mb-1"><i class="bi bi-shield-check me-1"></i> Registration Transparency</strong>
                        {{ setting('registration_statement', 'The network operates through institutions registered with relevant education and skills-development authorities, including SBTE and NAVTTC, subject to the respective centre and approved programme registrations.') }}
                    </div>
                </div>

                <!-- Network Brands -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-uppercase text-warning fw-bold small mb-3 letter-spacing-1">Our Brands</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><a href="{{ url('/centres?brand=fs-education') }}" class="text-white-50 text-decoration-none hover-white">F.S. Education</a></li>
                        <li class="mb-2"><a href="{{ url('/centres?brand=aptech') }}" class="text-white-50 text-decoration-none hover-white">Aptech Computer Education</a></li>
                        <li class="mb-2"><a href="{{ url('/centres?brand=arena-multimedia') }}" class="text-white-50 text-decoration-none hover-white">Arena Multimedia</a></li>
                        <li class="mb-2"><a href="{{ url('/accreditations') }}" class="text-white-50 text-decoration-none hover-white">SBTE Affiliation</a></li>
                        <li class="mb-2"><a href="{{ url('/accreditations') }}" class="text-white-50 text-decoration-none hover-white">NAVTTC Accreditation</a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-uppercase text-warning fw-bold small mb-3 letter-spacing-1">Quick Links</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><a href="{{ url('/about') }}" class="text-white-50 text-decoration-none hover-white">About the Group</a></li>
                        <li class="mb-2"><a href="{{ url('/courses') }}" class="text-white-50 text-decoration-none hover-white">All Programmes</a></li>
                        <li class="mb-2"><a href="{{ url('/mou-partners') }}" class="text-white-50 text-decoration-none hover-white">MOU Partner Discounts</a></li>
                        <li class="mb-2"><a href="{{ url('/become-a-partner') }}" class="text-white-50 text-decoration-none hover-white">Become a Partner</a></li>
                        <li class="mb-2"><a href="{{ url('/gallery') }}" class="text-white-50 text-decoration-none hover-white">Campus Gallery</a></li>
                        <li class="mb-2"><a href="{{ url('/contact') }}" class="text-white-50 text-decoration-none hover-white">Contact & Map</a></li>
                    </ul>
                </div>

                <!-- Contact & Social -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="text-uppercase text-warning fw-bold small mb-3 letter-spacing-1">Get in Touch</h6>
                    <ul class="list-unstyled small text-white-50 mb-3">
                        @if(setting('address'))
                            <li class="mb-2"><i class="bi bi-geo-alt text-warning me-2"></i> {{ setting('address') }}</li>
                        @endif
                        @if(setting('phone'))
                            <li class="mb-2"><i class="bi bi-telephone text-warning me-2"></i> {{ setting('phone') }}</li>
                        @endif
                        @if(setting('whatsapp'))
                            <li class="mb-2"><i class="bi bi-whatsapp text-success me-2"></i> WhatsApp: {{ setting('whatsapp') }}</li>
                        @endif
                        @if(setting('email'))
                            <li class="mb-2"><i class="bi bi-envelope text-warning me-2"></i> {{ setting('email') }}</li>
                        @endif
                    </ul>
                    <div class="d-flex gap-2 mt-3">
                        @if(setting('facebook_url'))<a href="{{ setting('facebook_url') }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-facebook"></i></a>@endif
                        @if(setting('instagram_url'))<a href="{{ setting('instagram_url') }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-instagram"></i></a>@endif
                        @if(setting('linkedin_url'))<a href="{{ setting('linkedin_url') }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-linkedin"></i></a>@endif
                        @if(setting('youtube_url'))<a href="{{ setting('youtube_url') }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-youtube"></i></a>@endif
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center small text-white-50">
                <div>
                    &copy; {{ date('Y') }} {{ setting('company_legal_name', setting('company_name', 'F.S. Education Network (Pvt) Ltd')) }}. All rights reserved.
                </div>
                <div class="d-flex gap-3">
                    <span class="text-white-50">Franchise operations (Aptech & Arena Multimedia) are subject to franchisor governance and brand standards.</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
