@extends('layouts.admin')

@section('page_title', 'Statutory Affiliations & Accreditations')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-patch-check me-2 text-primary"></i> External Affiliations (SBTE & NAVTTC)</h6>
            <small class="text-muted">Statutory boards certifying designated F.S. Education programmes.</small>
        </div>
        <a href="{{ route('admin.affiliations.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Affiliation Authority
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 sortable-table" data-reorder-url="{{ route('admin.affiliations.reorder') }}">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th style="width: 90px;">Logo</th>
                        <th>Short Name</th>
                        <th>Full Authority Name</th>
                        <th>Registered Programmes</th>
                        <th>Website</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($affiliations as $affiliation)
                        <tr data-id="{{ $affiliation->id }}">
                            <td class="text-muted text-center">
                                <i class="bi bi-grip-vertical drag-handle fs-5"></i>
                            </td>
                            <td>
                                <div class="rounded border p-1 d-flex align-items-center justify-content-center bg-white" style="width: 70px; height: 40px;">
                                    @if($affiliation->logo)
                                        <img src="{{ asset('storage/' . $affiliation->logo) }}" alt="{{ $affiliation->short_name }}" style="max-height: 32px; max-width: 60px; object-fit: contain;">
                                    @else
                                        <span class="badge bg-primary">{{ $affiliation->short_name }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong class="text-primary">{{ $affiliation->short_name }}</strong>
                            </td>
                            <td class="text-dark fw-semibold">
                                {{ $affiliation->name }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $affiliation->courses_count }} Courses</span>
                            </td>
                            <td>
                                @if($affiliation->website_url)
                                    <a href="{{ $affiliation->website_url }}" target="_blank" rel="noopener" class="small text-decoration-none">
                                        {{ Str::limit($affiliation->website_url, 30) }} <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if($affiliation->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Hidden</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.affiliations.edit', $affiliation) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.affiliations.destroy', $affiliation) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this affiliation? Only allowed if no courses are assigned.">
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
                                No statutory affiliations configured.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

