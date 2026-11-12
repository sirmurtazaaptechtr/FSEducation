@extends('layouts.admin')

@section('page_title', 'Edit MOU Partnership')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil me-2 text-primary"></i> Edit MOU Partner: {{ $mouPartner->name }}</h6>
            </div>

            <form method="POST" action="{{ route('admin.mou-partners.update', $mouPartner) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label fw-bold">Partner Organization Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $mouPartner->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="organization_type" class="form-label fw-bold">Organization Type <span class="text-danger">*</span></label>
                            <select name="organization_type" id="organization_type" class="form-select @error('organization_type') is-invalid @enderror" required>
                                <option value="corporate" {{ old('organization_type', $mouPartner->organization_type) === 'corporate' ? 'selected' : '' }}>Corporate Company</option>
                                <option value="school" {{ old('organization_type', $mouPartner->organization_type) === 'school' ? 'selected' : '' }}>School</option>
                                <option value="college" {{ old('organization_type', $mouPartner->organization_type) === 'college' ? 'selected' : '' }}>College</option>
                                <option value="university" {{ old('organization_type', $mouPartner->organization_type) === 'university' ? 'selected' : '' }}>University</option>
                                <option value="ngo" {{ old('organization_type', $mouPartner->organization_type) === 'ngo' ? 'selected' : '' }}>NGO / Non-Profit</option>
                                <option value="association" {{ old('organization_type', $mouPartner->organization_type) === 'association' ? 'selected' : '' }}>Trade Association / Chamber</option>
                                <option value="other" {{ old('organization_type', $mouPartner->organization_type) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="short_description" class="form-label fw-bold">Short Benefit Summary</label>
                            <textarea name="short_description" id="short_description" rows="2" class="form-control">{{ old('short_description', $mouPartner->short_description) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">Full Partnership Description & Context</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $mouPartner->description) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Partner Logo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 120px; height: 60px;" id="preview-mou-logo">
                                    @if($mouPartner->logo)
                                        <img src="{{ asset('storage/' . $mouPartner->logo) }}" alt="Logo">
                                    @else
                                        <span class="text-muted small">No Logo</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" class="form-control image-upload-input" data-preview-target="preview-mou-logo" accept="image/*">
                                    <div class="form-text">Leave blank to keep existing logo.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">MOU Cover / Feature Banner (Optional)</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 140px; height: 75px;" id="preview-mou-cover">
                                    @if($mouPartner->cover_image)
                                        <img src="{{ asset('storage/' . $mouPartner->cover_image) }}" alt="Cover">
                                    @else
                                        <span class="text-muted small">No Cover</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="cover_image" class="form-control image-upload-input" data-preview-target="preview-mou-cover" accept="image/*">
                                    <div class="form-text">Leave blank to retain current cover.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="website_url" class="form-label fw-bold">Partner Website URL</label>
                            <input type="url" name="website_url" id="website_url" class="form-control" value="{{ old('website_url', $mouPartner->website_url) }}">
                        </div>

                        <hr class="my-3">
                        <h6 class="fw-bold text-dark mb-2">Discount Specifics & Promo Codes</h6>

                        <div class="col-md-4">
                            <label for="discount_type" class="form-label fw-bold">Discount Type <span class="text-danger">*</span></label>
                            <select name="discount_type" id="discount_type" class="form-select @error('discount_type') is-invalid @enderror" required>
                                <option value="percentage" {{ old('discount_type', $mouPartner->discount_type) === 'percentage' ? 'selected' : '' }}>Percentage Discount (%)</option>
                                <option value="fixed" {{ old('discount_type', $mouPartner->discount_type) === 'fixed' ? 'selected' : '' }}>Fixed Amount (PKR)</option>
                                <option value="custom_text" {{ old('discount_type', $mouPartner->discount_type) === 'custom_text' ? 'selected' : '' }}>Special Package / Custom</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="discount_value" class="form-label fw-bold">Discount Value</label>
                            <input type="text" name="discount_value" id="discount_value" class="form-control" value="{{ old('discount_value', $mouPartner->discount_value) }}">
                        </div>

                        <div class="col-md-4">
                            <label for="discount_label" class="form-label fw-bold">Public Discount Badge Label <span class="text-danger">*</span></label>
                            <input type="text" name="discount_label" id="discount_label" class="form-control @error('discount_label') is-invalid @enderror" value="{{ old('discount_label', $mouPartner->discount_label) }}" required>
                            @error('discount_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="referral_code" class="form-label fw-bold">Referral Promo Code</label>
                            <input type="text" name="referral_code" id="referral_code" class="form-control font-monospace" value="{{ old('referral_code', $mouPartner->referral_code) }}">
                        </div>

                        <div class="col-md-4">
                            <label for="valid_from" class="form-label fw-bold">Valid From Date</label>
                            <input type="date" name="valid_from" id="valid_from" class="form-control" value="{{ old('valid_from', $mouPartner->valid_from ? $mouPartner->valid_from->format('Y-m-d') : '') }}">
                        </div>

                        <div class="col-md-4">
                            <label for="valid_until" class="form-label fw-bold">Valid Until Date</label>
                            <input type="date" name="valid_until" id="valid_until" class="form-control" value="{{ old('valid_until', $mouPartner->valid_until ? $mouPartner->valid_until->format('Y-m-d') : '') }}">
                        </div>

                        <!-- Brand Applicability Scope -->
                        <div class="col-12">
                            <div class="p-3 bg-light border rounded">
                                <label class="form-label fw-bold mb-1 d-block text-dark">Brand Applicability Scope</label>
                                <div class="alert alert-warning py-2 small mb-3">
                                    <i class="bi bi-shield-exclamation me-1"></i> <strong>Franchisor Rule Notice:</strong>
                                    Check franchisor rules before applying discounts to Aptech or Arena programmes.
                                </div>
                                <div class="row g-2">
                                    @foreach($brands as $brand)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="brands[]" value="{{ $brand->id }}" id="brand_{{ $brand->id }}" {{ in_array($brand->id, old('brands', $selectedBrandIds)) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="brand_{{ $brand->id }}">
                                                    <span class="badge {{ $brand->isFsEducation() ? 'badge-brand-fs' : ($brand->slug === 'aptech' ? 'badge-brand-aptech' : 'badge-brand-arena') }} me-1">
                                                        {{ $brand->name }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Specific Course Restrictions -->
                        <div class="col-12">
                            <label class="form-label fw-bold mb-1">Restrict Discount to Specific Courses (Optional)</label>
                            <div class="form-text mb-2">Leave blank if the discount applies across all courses under the selected brands above.</div>
                            <div class="row g-2 border rounded p-3 bg-light" style="max-height: 180px; overflow-y: auto;">
                                @foreach($courses as $course)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="{{ $course->id }}" id="course_{{ $course->id }}" {{ in_array($course->id, old('courses', $selectedCourseIds)) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="course_{{ $course->id }}">
                                                <span class="badge {{ $course->brand->isFsEducation() ? 'badge-brand-fs' : ($course->brand->slug === 'aptech' ? 'badge-brand-aptech' : 'badge-brand-arena') }} me-1" style="font-size: 0.65rem;">
                                                    {{ $course->brand->name }}
                                                </span>
                                                {{ $course->title }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="terms" class="form-label fw-bold">Terms & Conditions</label>
                            <textarea name="terms" id="terms" rows="3" class="form-control">{{ old('terms', $mouPartner->terms) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="how_to_avail" class="form-label fw-bold">How to Avail Steps</label>
                            <textarea name="how_to_avail" id="how_to_avail" rows="3" class="form-control">{{ old('how_to_avail', $mouPartner->how_to_avail) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $mouPartner->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Active partnership
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $mouPartner->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_featured">
                                    Feature on homepage MOU strip
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.mou-partners.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Update MOU Partner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

