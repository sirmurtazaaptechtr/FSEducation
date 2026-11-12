@extends('layouts.admin')

@section('page_title', 'Key Figures & Statistics')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-123 me-2 text-primary"></i> Homepage Key Figures</h6>
            <small class="text-muted">Drag rows to reorder statistical figures displayed on the public homepage.</small>
        </div>
        <a href="{{ route('admin.stats.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Key Figure
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 sortable-table" data-reorder-url="{{ route('admin.stats.reorder') }}">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th style="width: 60px;">Icon</th>
                        <th>Metric Label</th>
                        <th>Value & Suffix</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats as $stat)
                        <tr data-id="{{ $stat->id }}">
                            <td class="text-muted text-center">
                                <i class="bi bi-grip-vertical drag-handle fs-5"></i>
                            </td>
                            <td>
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fs-5" style="width: 40px; height: 40px;">
                                    <i class="bi {{ $stat->icon ?? 'bi-bar-chart' }}"></i>
                                </div>
                            </td>
                            <td class="fw-semibold text-dark">
                                {{ $stat->label }}
                            </td>
                            <td>
                                <span class="fs-5 fw-bold text-primary">{{ $stat->value }}</span><span class="fs-5 fw-bold text-secondary">{{ $stat->suffix }}</span>
                            </td>
                            <td>
                                @if($stat->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Hidden</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.stats.edit', $stat) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.stats.destroy', $stat) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this key figure?">
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
                            <td colspan="6" class="text-center py-4 text-muted">
                                No key figures created yet. Click "Add Key Figure" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

