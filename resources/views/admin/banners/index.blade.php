@extends('layouts.admin')

@section('page_title', 'Hero Marketing Banners')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-images me-2 text-primary"></i> Homepage Carousel Banners</h6>
            <small class="text-muted">Drag rows to reorder banner sequence on the live website.</small>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add New Banner
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 sortable-table" data-reorder-url="{{ route('admin.banners.reorder') }}">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th style="width: 140px;">Preview</th>
                        <th>Banner Content</th>
                        <th>CTA Link</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr data-id="{{ $banner->id }}">
                            <td class="text-muted text-center">
                                <i class="bi bi-grip-vertical drag-handle fs-5"></i>
                            </td>
                            <td>
                                <div class="rounded border overflow-hidden" style="width: 120px; height: 60px; background: #e2e8f0;">
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-100 h-100 object-fit-cover">
                                </div>
                            </td>
                            <td>
                                <strong class="d-block text-dark">{{ $banner->title }}</strong>
                                <small class="text-muted">{{ Str::limit($banner->subtitle, 80) }}</small>
                            </td>
                            <td>
                                @if($banner->button_text && $banner->button_url)
                                    <span class="badge bg-light text-dark border">
                                        {{ $banner->button_text }} &rarr; {{ $banner->button_url }}
                                    </span>
                                @else
                                    <span class="text-muted small">No button</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                @if($banner->starts_at || $banner->ends_at)
                                    <div>From: {{ $banner->starts_at ? $banner->starts_at->format('M d, Y') : 'Now' }}</div>
                                    <div>To: {{ $banner->ends_at ? $banner->ends_at->format('M d, Y') : 'Indefinite' }}</div>
                                @else
                                    Always Visible
                                @endif
                            </td>
                            <td>
                                @if(!$banner->is_active)
                                    <span class="badge bg-secondary">Draft / Inactive</span>
                                @elseif($banner->starts_at && $banner->starts_at->isFuture())
                                    <span class="badge bg-info text-dark">Scheduled</span>
                                @elseif($banner->ends_at && $banner->ends_at->isPast())
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this banner permanently?">
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
                            <td colspan="7" class="text-center py-4 text-muted">
                                No banners created yet. Click "Add New Banner" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

