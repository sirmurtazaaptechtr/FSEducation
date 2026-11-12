@extends('layouts.admin')

@section('page_title', 'Network Campuses & Centres')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-building me-2 text-primary"></i> 5 Karachi Network Centres</h6>
            <small class="text-muted">Drag rows to change display order on the public network page.</small>
        </div>
        <a href="{{ route('admin.centres.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Centre
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 sortable-table" data-reorder-url="{{ route('admin.centres.reorder') }}">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th style="width: 100px;">Cover</th>
                        <th>Centre / Campus</th>
                        <th>Operating Brand</th>
                        <th>Location & Contact</th>
                        <th>Programmes</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($centres as $centre)
                        <tr data-id="{{ $centre->id }}">
                            <td class="text-muted text-center">
                                <i class="bi bi-grip-vertical drag-handle fs-5"></i>
                            </td>
                            <td>
                                <div class="rounded border overflow-hidden" style="width: 90px; height: 55px; background: #e2e8f0;">
                                    @if($centre->cover_image)
                                        <img src="{{ asset('storage/' . $centre->cover_image) }}" alt="{{ $centre->name }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small"><i class="bi bi-image"></i></div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong class="text-dark d-block">{{ $centre->name }}</strong>
                                <small class="text-muted">{{ $centre->area }}, {{ $centre->city }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $centre->brand->isFsEducation() ? 'badge-brand-fs' : ($centre->brand->slug === 'aptech' ? 'badge-brand-aptech' : 'badge-brand-arena') }}">
                                    {{ $centre->brand->name }}
                                </span>
                            </td>
                            <td class="small">
                                <div><i class="bi bi-telephone text-muted me-1"></i> {{ $centre->phone ?? '—' }}</div>
                                @if($centre->whatsapp)
                                    <div><i class="bi bi-whatsapp text-success me-1"></i> {{ $centre->whatsapp }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $centre->courses_count }} Courses</span>
                                <small class="text-muted d-block">{{ $centre->images_count }} photos</small>
                            </td>
                            <td>
                                @if($centre->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.centres.edit', $centre) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.centres.destroy', $centre) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this campus centre?">
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
                                No centres created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

