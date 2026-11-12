@extends('layouts.admin')

@section('page_title', 'Add Network Brand')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-plus-circle me-2 text-primary"></i> Create Brand</h6>
            </div>

            <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label fw-bold">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Aptech">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="slug" class="form-label fw-bold">Slug (Optional)</label>
                            <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Auto-generated if left blank">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Brand Logo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" id="preview-brand-logo">
                                    <span class="text-muted small">Logo</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" class="form-control image-upload-input" data-preview-target="preview-brand-logo" accept="image/*">
                                    <div class="form-text">Recommended size: 400x200px PNG or WebP.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">Brand Overview & Franchisor Notes</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Active operating brand
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Save Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
