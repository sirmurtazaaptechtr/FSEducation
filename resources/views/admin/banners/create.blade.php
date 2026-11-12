@extends('layouts.admin')

@section('page_title', 'Create Marketing Banner')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-plus-circle me-2 text-primary"></i> New Carousel Banner</h6>
            </div>

            <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title" class="form-label fw-bold">Banner Headline <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Empowering Next-Generation Professionals">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="subtitle" class="form-label fw-bold">Subtitle / Description</label>
                            <textarea name="subtitle" id="subtitle" rows="2" class="form-control @error('subtitle') is-invalid @enderror" placeholder="Brief supporting message">{{ old('subtitle') }}</textarea>
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Banner Image <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 200px; height: 90px;" id="preview-banner">
                                    <span class="text-muted small">1920 x 800 px</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image" class="form-control image-upload-input @error('image') is-invalid @enderror" data-preview-target="preview-banner" accept="image/*" required>
                                    <div class="form-text">Recommended size: 1920 x 800 pixels (JPG, PNG, WebP). Converted automatically to modern WebP.</div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="button_text" class="form-label fw-bold">Call to Action Button Text</label>
                            <input type="text" name="button_text" id="button_text" class="form-control" value="{{ old('button_text') }}" placeholder="e.g. Explore Programmes">
                        </div>

                        <div class="col-md-6">
                            <label for="button_url" class="form-label fw-bold">Button Link URL</label>
                            <input type="text" name="button_url" id="button_url" class="form-control" value="{{ old('button_url') }}" placeholder="e.g. /courses or https://...">
                        </div>

                        <div class="col-md-6">
                            <label for="starts_at" class="form-label fw-bold">Schedule Start Date (Optional)</label>
                            <input type="datetime-local" name="starts_at" id="starts_at" class="form-control" value="{{ old('starts_at') }}">
                            <div class="form-text">Leave blank to show immediately.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="ends_at" class="form-label fw-bold">Schedule End Date (Optional)</label>
                            <input type="datetime-local" name="ends_at" id="ends_at" class="form-control" value="{{ old('ends_at') }}">
                            <div class="form-text">Leave blank to keep visible indefinitely.</div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Publish this banner immediately
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Save Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

