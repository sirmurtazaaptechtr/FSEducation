@extends('layouts.admin')

@section('page_title', 'Network Brands')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-tags me-2 text-primary"></i> Operating Network Brands</h6>
            <small class="text-muted">Parent brand (F.S. Education) and franchised operating brands.</small>
        </div>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Brand
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 100px;">Logo</th>
                        <th>Brand Name</th>
                        <th>Role in Network</th>
                        <th>Centres</th>
                        <th>Courses</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                        <tr>
                            <td>
                                <div class="rounded border p-1 d-flex align-items-center justify-content-center bg-white" style="width: 80px; height: 45px;">
                                    @if($brand->logo)
                                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="max-height: 38px; max-width: 70px; object-fit: contain;">
                                    @else
                                        <span class="badge {{ $brand->isFsEducation() ? 'badge-brand-fs' : ($brand->slug === 'aptech' ? 'badge-brand-aptech' : 'badge-brand-arena') }}">
                                            {{ strtoupper(substr($brand->name, 0, 3)) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong class="text-dark d-block">{{ $brand->name }}</strong>
                                <small class="text-muted font-monospace">slug: {{ $brand->slug }}</small>
                            </td>
                            <td>
                                @if($brand->isFsEducation())
                                    <span class="badge bg-primary"><i class="bi bi-shield-shaded me-1"></i> Parent Group Brand</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-award me-1"></i> Franchised Operating Brand</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $brand->centres_count }} Campuses</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $brand->courses_count }} Programmes</span>
                            </td>
                            <td>
                                @if($brand->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-outline-secondary" title="Edit Brand">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if(!$brand->isFsEducation())
                                        <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this brand? Only allowed if no centres or courses are assigned.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="franchise-guideline-box mt-4 shadow-sm">
    <h6 class="fw-bold mb-1"><i class="bi bi-info-circle me-1"></i> Franchisor Brand Rule Notice</h6>
    Content, marks, and certificates issued under <strong>Aptech</strong> and <strong>Arena Multimedia</strong> must adhere strictly to franchisor agreements. They must never carry government affiliation badges (SBTE/NAVTTC).
</div>
@endsection

