@extends('layouts.admin')

@section('page_title', 'Dashboard Overview')

@section('content')
<div class="row g-3 mb-4">
    <!-- Total Centres -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 me-3 fs-3">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1 text-uppercase fw-semibold">Network Centres</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $metrics['total_centres'] }}</h3>
                    <small class="text-muted">5 Karachi Campuses</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Courses -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-success bg-opacity-10 text-success p-3 me-3 fs-3">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1 text-uppercase fw-semibold">Courses & Diplomas</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $metrics['total_courses'] }}</h3>
                    <small class="text-muted">SBTE, NAVTTC & Franchise</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Active MOUs -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-3 me-3 fs-3">
                    <i class="bi bi-handshake-fill"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1 text-uppercase fw-semibold">Active MOUs</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $metrics['active_mous'] }}</h3>
                    <small class="text-muted">Currently active discounts</small>
                </div>
            </div>
        </div>
    </div>

    <!-- New Inquiries -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-danger bg-opacity-10 text-danger p-3 me-3 fs-3">
                    <i class="bi bi-bell-fill"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1 text-uppercase fw-semibold">New Inquiries</h6>
                    <h3 class="fw-bold mb-0 text-danger">{{ $metrics['new_inquiries'] }}</h3>
                    <small class="text-muted">{{ $metrics['total_inquiries'] }} lifetime leads</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Metrics -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small d-block">MOU Inquiries This Month</span>
                    <h4 class="fw-bold mb-0 text-primary">{{ $metrics['mou_inquiries_month'] }}</h4>
                </div>
                <span class="badge bg-primary rounded-pill p-2"><i class="bi bi-tag-fill"></i> Partner Leads</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small d-block">Pending Partner Requests</span>
                    <h4 class="fw-bold mb-0 text-warning">{{ $metrics['new_partner_requests'] }}</h4>
                </div>
                <span class="badge bg-warning text-dark rounded-pill p-2"><i class="bi bi-envelope-check"></i> Partnerships</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small d-block">Active Hero Banners</span>
                    <h4 class="fw-bold mb-0 text-info">{{ $metrics['active_banners'] }}</h4>
                </div>
                <span class="badge bg-info text-white rounded-pill p-2"><i class="bi bi-display"></i> Scheduled</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Student Inquiries -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-inbox me-2 text-primary"></i> Latest Inquiries (Marketing Attribution)</h6>
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-primary">View All Inquiries</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Programme / Centre</th>
                                <th>MOU Referral</th>
                                <th>Traffic Source</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInquiries as $inquiry)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $inquiry->name }}</div>
                                        <small class="text-muted">{{ $inquiry->phone }}</small>
                                    </td>
                                    <td>
                                        <div class="small fw-semibold">{{ $inquiry->course->title ?? 'General Admission' }}</div>
                                        <small class="text-muted">{{ $inquiry->centre->name ?? 'Any Centre' }}</small>
                                    </td>
                                    <td>
                                        @if($inquiry->mouPartner)
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-handshake me-1"></i> {{ $inquiry->mouPartner->name }}
                                            </span>
                                            @if($inquiry->referral_code_entered)
                                                <small class="d-block text-muted font-monospace">{{ $inquiry->referral_code_entered }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted small">Direct</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inquiry->utm_source || $inquiry->utm_campaign)
                                            <span class="badge bg-light text-dark border">
                                                {{ $inquiry->utm_source ?? 'direct' }} / {{ $inquiry->utm_campaign ?? 'none' }}
                                            </span>
                                        @else
                                            <span class="text-muted small">Organic / Direct</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inquiry->status === 'new')
                                            <span class="badge bg-danger">New</span>
                                        @elseif($inquiry->status === 'contacted')
                                            <span class="badge bg-info">Contacted</span>
                                        @else
                                            <span class="badge bg-success">Closed</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">
                                        {{ $inquiry->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-3 d-block mb-1 text-muted"></i>
                                        No student inquiries received yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts & Partner Requests -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-lightning-charge me-2 text-warning"></i> Quick Actions</h6>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('admin.courses.create') }}" class="btn btn-light text-start border">
                    <i class="bi bi-plus-circle text-primary me-2"></i> Add New Course / Programme
                </a>
                <a href="{{ route('admin.mou-partners.create') }}" class="btn btn-light text-start border">
                    <i class="bi bi-handshake text-warning me-2"></i> Register New MOU Partner
                </a>
                <a href="{{ route('admin.banners.create') }}" class="btn btn-light text-start border">
                    <i class="bi bi-images text-info me-2"></i> Create Marketing Banner
                </a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-light text-start border">
                        <i class="bi bi-sliders text-danger me-2"></i> Manage Site Settings
                    </a>
                @endif
            </div>
        </div>

        <!-- Recent Partner Requests -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-building-add me-2 text-info"></i> Partner Requests</h6>
                <a href="{{ route('admin.partner-requests.index') }}" class="small text-decoration-none">View All</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentPartnerRequests as $req)
                        <li class="list-group-item py-3">
                            <div class="d-flex justify-content-between">
                                <strong class="small">{{ $req->organization_name }}</strong>
                                <span class="badge {{ $req->status === 'new' ? 'bg-danger' : 'bg-secondary' }}">{{ $req->status }}</span>
                            </div>
                            <small class="text-muted d-block">{{ $req->contact_person }} • {{ $req->phone }}</small>
                            <small class="text-muted d-block">{{ Str::limit($req->message, 60) }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted small">
                            No partnership inquiries pending.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

