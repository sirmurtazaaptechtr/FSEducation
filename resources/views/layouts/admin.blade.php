<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Portal') | {{ setting('company_name', 'F.S. Education') }}</title>

    <!-- Vite Assets -->
    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar shadow-sm">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="bi bi-mortarboard-fill text-warning fs-4"></i>
                <div class="lh-1">
                    <span class="d-block fw-bold text-white fs-6">{{ setting('company_name', 'F.S. Education') }}</span>
                    <small class="text-white-50 font-monospace" style="font-size: 0.7rem;">Control Panel</small>
                </div>
            </a>

            <div class="p-3 border-bottom border-light border-opacity-10 d-flex align-items-center gap-2">
                <div class="rounded-circle bg-warning text-dark fw-bold d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-white small fw-bold text-truncate">{{ Auth::user()->name }}</div>
                    <span class="badge {{ Auth::user()->isAdmin() ? 'bg-danger' : 'bg-info' }} text-uppercase" style="font-size: 0.65rem;">
                        {{ Auth::user()->role }}
                    </span>
                </div>
            </div>

            <nav class="flex-grow-1 overflow-auto py-2">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>

                    <div class="sidebar-heading">Core Institutions</div>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
                            <i class="bi bi-tags"></i> Brands
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.affiliations.*') ? 'active' : '' }}" href="{{ route('admin.affiliations.index') }}">
                            <i class="bi bi-patch-check"></i> Affiliations (SBTE/NAVTTC)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.centres.*') ? 'active' : '' }}" href="{{ route('admin.centres.index') }}">
                            <i class="bi bi-building"></i> Centres (5 Campuses)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.course-categories.*') ? 'active' : '' }}" href="{{ route('admin.course-categories.index') }}">
                            <i class="bi bi-folder2"></i> Course Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                            <i class="bi bi-journal-text"></i> Courses & Programmes
                        </a>
                    </li>

                    <div class="sidebar-heading">Partnerships & Leads</div>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.mou-partners.*') ? 'active' : '' }}" href="{{ route('admin.mou-partners.index') }}">
                            <i class="bi bi-handshake"></i> MOU Partners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.partner-requests.*') ? 'active' : '' }}" href="{{ route('admin.partner-requests.index') }}">
                            <i class="bi bi-envelope-paper"></i> Partner Requests
                            @php
                                $newRequests = \App\Models\PartnerRequest::where('status', 'new')->count();
                            @endphp
                            @if($newRequests > 0)
                                <span class="badge bg-danger ms-auto">{{ $newRequests }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}" href="{{ route('admin.inquiries.index') }}">
                            <i class="bi bi-chat-left-dots"></i> Student Inquiries
                            @php
                                $newInquiries = \App\Models\Inquiry::where('status', 'new')->count();
                            @endphp
                            @if($newInquiries > 0)
                                <span class="badge bg-warning text-dark ms-auto">{{ $newInquiries }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                            <i class="bi bi-bar-chart-line"></i> MOU & Traffic Reports
                        </a>
                    </li>

                    <div class="sidebar-heading">Content & Media</div>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                            <i class="bi bi-images"></i> Hero Banners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}" href="{{ route('admin.stats.index') }}">
                            <i class="bi bi-123"></i> Key Figures (Stats)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}" href="{{ route('admin.partners.index') }}">
                            <i class="bi bi-grid-3x3-gap"></i> General Partners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                            <i class="bi bi-file-earmark-richtext"></i> Custom Pages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                            <i class="bi bi-newspaper"></i> News & Updates
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}" href="{{ route('admin.gallery.index') }}">
                            <i class="bi bi-camera"></i> Campus Gallery
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
                            <i class="bi bi-quote"></i> Testimonials
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}" href="{{ route('admin.team.index') }}">
                            <i class="bi bi-people"></i> Team & Leadership
                        </a>
                    </li>

                    @if(Auth::user()->isAdmin())
                        <div class="sidebar-heading">System Administration</div>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                                <i class="bi bi-sliders"></i> Site Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-person-gear"></i> User Accounts
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <div class="p-3 border-top border-light border-opacity-10">
                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-light btn-sm w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-up-right"></i> View Live Website
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="admin-content">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0 fw-bold text-dark">@yield('page_title', 'Dashboard')</h5>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <span class="d-block small fw-bold">{{ Auth::user()->name }}</span>
                        <span class="text-muted small">{{ Auth::user()->email }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Sign Out">
                            <i class="bi bi-box-arrow-right me-1"></i> Sign Out
                        </button>
                    </form>
                </div>
            </header>

            <!-- Body Container -->
            <main class="admin-body">
                <!-- Flash Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <strong class="d-block mb-1"><i class="bi bi-x-circle-fill me-2"></i> Please correct the following errors:</strong>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

