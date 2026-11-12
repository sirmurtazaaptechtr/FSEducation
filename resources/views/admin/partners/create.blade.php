@extends('layouts.admin')

@section('page_title', 'Add Partner Logo')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-plus-circle me-2 text-primary"></i> Add Partner or Accreditation Logo</h6>
            </div>

            <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label fw-bold">Organization Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Sindh Board of Technical Education">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Organization Logo <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 140px; height: 70px;" id="preview-partner">
                                    <span class="text-muted small">Logo Preview</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" class="form-control image-upload-input @error('logo') is-invalid @enderror" data-preview-target="preview-partner" accept="image/*" required>
                                    <div class="form-text">Recommended size: 400 x 200 pixels. Transparent PNG or WebP.</div>
                                    @error('logo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="type" class="form-label fw-bold">Organization Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="affiliation" {{ old('type') === 'affiliation' ? 'selected' : '' }}>Statutory Affiliation (e.g. SBTE)</option>
                                <option value="accreditation" {{ old('type') === 'accreditation' ? 'selected' : '' }}>National Accreditation (e.g. NAVTTC)</option>
                                <option value="partner" {{ old('type', 'partner') === 'partner' ? 'selected' : '' }}>Industry / Corporate Partner</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="url" class="form-label fw-bold">Official Website URL</label>
                            <input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" placeholder="https://example.com">
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Display logo on the public website
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Save Partner Logo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

