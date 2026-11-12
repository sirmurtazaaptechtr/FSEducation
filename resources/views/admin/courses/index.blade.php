@extends('layouts.admin')

@section('page_title', 'Programmes & Courses')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.courses.index') }}" class="row g-2 align-items-center">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by title or reg #" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="brand_id" class="form-select form-select-sm">
                    <option value="">All Brands</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="approval_status" class="form-select form-select-sm">
                    <option value="">All Approval Status</option>
                    <option value="approved" {{ request('approval_status') === 'approved' ? 'selected' : '' }}>Approved Only</option>
                    <option value="pending" {{ request('approval_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="none" {{ request('approval_status') === 'none' ? 'selected' : '' }}>None (Standard)</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="affiliation_id" class="form-select form-select-sm">
                    <option value="">All Affiliations</option>
                    @foreach($affiliations as $aff)
                        <option value="{{ $aff->id }}" {{ request('affiliation_id') == $aff->id ? 'selected' : '' }}>{{ $aff->short_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bi bi-filter"></i></button>
                @if(request()->hasAny(['search', 'brand_id', 'category_id', 'approval_status', 'affiliation_id']))
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm" title="Clear filters"><i class="bi bi-x"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-journal-text me-2 text-primary"></i> Course Catalog ({{ $courses->total() }} Total)</h6>
            <small class="text-muted">Approval badges render publicly ONLY for explicitly approved programmes.</small>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Programme
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Programme Title</th>
                        <th>Brand & Category</th>
                        <th>Affiliation / Approval</th>
                        <th>Centres</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>
                                <div class="rounded border overflow-hidden" style="width: 70px; height: 45px; background: #e2e8f0;">
                                    @if($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small"><i class="bi bi-book"></i></div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong class="text-dark d-block">{{ $course->title }}</strong>
                                <small class="text-muted font-monospace">{{ $course->slug }}</small>
                                @if($course->is_featured)
                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">Featured</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $course->brand->isFsEducation() ? 'badge-brand-fs' : ($course->brand->slug === 'aptech' ? 'badge-brand-aptech' : 'badge-brand-arena') }}">
                                    {{ $course->brand->name }}
                                </span>
                                <small class="text-muted d-block mt-1">{{ $course->category->name ?? 'General' }}</small>
                            </td>
                            <td>
                                @if($course->affiliation)
                                    <span class="badge bg-primary me-1">{{ $course->affiliation->short_name }}</span>
                                    @if($course->approval_status === 'approved')
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Approved</span>
                                        @if($course->registration_reference)
                                            <small class="d-block text-muted font-monospace" style="font-size: 0.7rem;">{{ $course->registration_reference }}</small>
                                        @endif
                                    @elseif($course->approval_status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">Unapproved</span>
                                    @endif
                                @else
                                    <span class="text-muted small">Standard Course (No Affiliation)</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $course->centres->count() }} Campuses</span>
                            </td>
                            <td class="small text-muted">
                                {{ $course->duration ?? 'Flexible' }}
                            </td>
                            <td>
                                @if($course->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this course?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No courses matching criteria found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($courses->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
