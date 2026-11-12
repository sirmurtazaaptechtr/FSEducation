@extends('layouts.admin')

@section('page_title', 'Edit Affiliation Authority')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil me-2 text-primary"></i> Edit Affiliation: {{ $affiliation->short_name }}</h6>
            </div>

            <form method="POST" action="{{ route('admin.affiliations.update', $affiliation) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="short_name" class="form-label fw-bold">Acronym / Code <span class="text-danger">*</span></label>
                            <input type="text" name="short_name" id="short_name" class="form-control @error('short_name') is-invalid @enderror" value="{{ old('short_name', $affiliation->short_name) }}" required>
                            @error('short_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="name" class="form-label fw-bold">Full Authority Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $affiliation->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Authority Logo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" id="preview-affil-logo">
                                    @if($affiliation->logo)
                                        <img src="{{ asset('storage/' . $affiliation->logo) }}" alt="Logo">
                                    @else
                                        <span class="text-muted small">Logo</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" class="form-control image-upload-input" data-preview-target="preview-affil-logo" accept="image/*">
                                    <div class="form-text">Leave blank to retain current logo.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="website_url" class="form-label fw-bold">Official Verification Portal URL</label>
                            <input type="url" name="website_url" id="website_url" class="form-control" value="{{ old('website_url', $affiliation->website_url) }}">
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">Authority Description & Mandate</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $affiliation->description) }}</textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $affiliation->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Active for programme registration
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.affiliations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Update Affiliation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

