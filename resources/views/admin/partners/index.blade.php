@extends('layouts.admin')

@section('page_title', 'Partners & Accreditations')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-grid-3x3-gap me-2 text-primary"></i> Partner Logos Strip</h6>
            <small class="text-muted">Drag rows to change the display sequence of partner and accreditation logos.</small>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Partner Logo
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 sortable-table" data-reorder-url="{{ route('admin.partners.reorder') }}">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th style="width: 120px;">Logo</th>
                        <th>Partner Name</th>
                        <th>Type</th>
                        <th>External Link</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($partners as $partner)
                        <tr data-id="{{ $partner->id }}">
                            <td class="text-muted text-center">
                                <i class="bi bi-grip-vertical drag-handle fs-5"></i>
                            </td>
                            <td>
                                <div class="rounded border p-1 d-flex align-items-center justify-content-center bg-white" style="width: 100px; height: 50px;">
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" style="max-height: 40px; max-width: 90px; object-fit: contain;">
                                </div>
                            </td>
                            <td class="fw-semibold text-dark">
                                {{ $partner->name }}
                            </td>
                            <td>
                                @if($partner->type === 'affiliation')
                                    <span class="badge bg-primary">Affiliation</span>
                                @elseif($partner->type === 'accreditation')
                                    <span class="badge bg-info text-dark">Accreditation</span>
                                @else
                                    <span class="badge bg-secondary">Industry Partner</span>
                                @endif
                            </td>
                            <td>
                                @if($partner->url)
                                    <a href="{{ $partner->url }}" target="_blank" rel="noopener" class="small text-decoration-none">
                                        {{ Str::limit($partner->url, 30) }} <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if($partner->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Hidden</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this partner logo?">
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
                                No partner logos registered yet. Click "Add Partner Logo" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
