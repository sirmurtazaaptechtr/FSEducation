@extends('layouts.admin')

@section('page_title', 'MOU Corporate & Institutional Partners')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-handshake me-2 text-warning"></i> Institutional MOU Partnerships</h6>
            <small class="text-muted">Expired MOUs stop displaying automatically on the public website.</small>
        </div>
        <a href="{{ route('admin.mou-partners.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Register New MOU
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 sortable-table" data-reorder-url="{{ route('admin.mou-partners.reorder') }}">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th style="width: 80px;">Logo</th>
                        <th>Partner Organization</th>
                        <th>Type</th>
                        <th>Agreed Discount</th>
                        <th>Brand Scope</th>
                        <th>Validity Window</th>
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
                                <div class="rounded border p-1 d-flex align-items-center justify-content-center bg-white" style="width: 60px; height: 38px;">
                                    @if($partner->logo)
                                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" style="max-height: 32px; max-width: 50px; object-fit: contain;">
                                    @else
                                        <span class="badge bg-light text-dark"><i class="bi bi-building"></i></span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong class="text-dark d-block">{{ $partner->name }}</strong>
                                @if($partner->referral_code)
                                    <small class="badge bg-light text-dark border font-monospace">Code: {{ $partner->referral_code }}</small>
                                @endif
                                @if($partner->is_featured)
                                    <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">Featured</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info text-dark text-capitalize">{{ $partner->organization_type }}</span>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">{{ $partner->discount_label }}</span>
                            </td>
                            <td>
                                @forelse($partner->brands as $brand)
                                    <span class="badge {{ $brand->isFsEducation() ? 'badge-brand-fs' : ($brand->slug === 'aptech' ? 'badge-brand-aptech' : 'badge-brand-arena') }} me-1">
                                        {{ $brand->name }}
                                    </span>
                                @empty
                                    <span class="badge bg-light text-muted border">None (Restricted)</span>
                                @endforelse
                            </td>
                            <td class="small text-muted">
                                @if($partner->valid_from || $partner->valid_until)
                                    <div>From: {{ $partner->valid_from ? $partner->valid_from->format('M d, Y') : 'Start' }}</div>
                                    <div>Until: {{ $partner->valid_until ? $partner->valid_until->format('M d, Y') : 'Ongoing' }}</div>
                                @else
                                    Ongoing
                                @endif
                            </td>
                            <td>
                                @php
                                    $status = $partner->status;
                                @endphp
                                @if($status === 'Active')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>
                                @elseif($status === 'Scheduled')
                                    <span class="badge bg-info text-dark"><i class="bi bi-clock me-1"></i> Scheduled</span>
                                @elseif($status === 'Expired')
                                    <span class="badge bg-danger"><i class="bi bi-hourglass-bottom me-1"></i> Expired</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.mou-partners.edit', $partner) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.mou-partners.destroy', $partner) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this MOU partnership?">
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
                            <td colspan="9" class="text-center py-4 text-muted">
                                No MOU partnerships registered. Click "Register New MOU" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
