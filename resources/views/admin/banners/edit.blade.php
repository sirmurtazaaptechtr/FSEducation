@extends('layouts.admin')

@section('page_title', 'Edit Marketing Banner')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil me-2 text-primary"></i> Edit Banner: {{ $banner->title }}</h6>
            </div>

            <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title" class="form-label fw-bold">Banner Headline <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="subtitle" class="form-label fw-bold">Subtitle / Description</label>
                            <textarea name="subtitle" id="subtitle" rows="2" class="form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle', $banner->subtitle) }}</textarea>
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Banner Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 200px; height: 90px;" id="preview-banner">
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Current Image">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image" class="form-control image-upload-input @error('image') is-invalid @enderror" data-preview-target="preview-banner" accept="image/*">
                                    <div class="form-text">Leave blank to keep existing image. Uploading a new image will replace the old one.</div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="button_text" class="form-label fw-bold">Call to Action Button Text</label>
                            <input type="text" name="button_text" id="button_text" class="form-control" value="{{ old('button_text', $banner->button_text) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="button_url" class="form-label fw-bold">Button Link URL</label>
                            <input type="text" name="button_url" id="button_url" class="form-control" value="{{ old('button_url', $banner->button_url) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="starts_at" class="form-label fw-bold">Schedule Start Date (Optional)</label>
                            <input type="datetime-local" name="starts_at" id="starts_at" class="form-control" value="{{ old('starts_at', $banner->starts_at ? $banner->starts_at->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="ends_at" class="form-label fw-bold">Schedule End Date (Optional)</label>
                            <input type="datetime-local" name="ends_at" id="ends_at" class="form-control" value="{{ old('ends_at', $banner->ends_at ? $banner->ends_at->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Active / Published
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Update Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

