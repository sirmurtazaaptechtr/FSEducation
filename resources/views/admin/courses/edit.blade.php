@extends('layouts.admin')

@section('page_title', 'Edit Programme / Course')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil me-2 text-primary"></i> Edit Programme: {{ $course->title }}</h6>
            </div>

            <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- 1. Brand Selection -->
                        <div class="col-md-6">
                            <label for="brand_id" class="form-label fw-bold">Brand Ownership <span class="text-danger">*</span></label>
                            <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" data-slug="{{ $brand->slug }}" {{ old('brand_id', $course->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }} ({{ $brand->isFsEducation() ? 'Parent Brand' : 'Franchise Brand' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Every course belongs to exactly one brand.</div>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 2. Category Selection -->
                        <div class="col-md-6">
                            <label for="course_category_id" class="form-label fw-bold">Course Category <span class="text-danger">*</span></label>
                            <select name="course_category_id" id="course_category_id" class="form-select @error('course_category_id') is-invalid @enderror" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('course_category_id', $course->course_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Franchise Rule Guidance Alert -->
                        <div class="col-12 d-none" id="franchise-warning-box">
                            <div class="franchise-guideline-box">
                                <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Franchisor Brand Rule:</strong>
                                Follow the franchisor's approved course description. External affiliations (SBTE/NAVTTC) are strictly restricted to F.S. Education courses and are prohibited for franchise courses.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="title" class="form-label fw-bold">Course / Programme Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $course->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="short_description" class="form-label fw-bold">Short Summary</label>
                            <textarea name="short_description" id="short_description" rows="2" class="form-control">{{ old('short_description', $course->short_description) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">Full Course Description & Curriculum</label>
                            <textarea name="description" id="description" rows="5" class="form-control">{{ old('description', $course->description) }}</textarea>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-shield-check me-1"></i> External Affiliation & Statutory Approval Status</h6>

                        <div class="col-md-4" id="affiliation-wrapper">
                            <label for="affiliation_id" class="form-label fw-bold">Affiliation Body</label>
                            <select name="affiliation_id" id="affiliation_id" class="form-select @error('affiliation_id') is-invalid @enderror">
                                <option value="">None (F.S. Education Internal / Non-affiliated)</option>
                                @foreach($affiliations as $affiliation)
                                    <option value="{{ $affiliation->id }}" {{ old('affiliation_id', $course->affiliation_id) == $affiliation->id ? 'selected' : '' }}>
                                        {{ $affiliation->short_name }} ({{ $affiliation->name }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Only available when F.S. Education is selected.</div>
                            @error('affiliation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="approval_status" class="form-label fw-bold">Approval Status <span class="text-danger">*</span></label>
                            <select name="approval_status" id="approval_status" class="form-select @error('approval_status') is-invalid @enderror" required>
                                <option value="none" {{ old('approval_status', $course->approval_status) === 'none' ? 'selected' : '' }}>None (Standard Programme)</option>
                                <option value="pending" {{ old('approval_status', $course->approval_status) === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                <option value="approved" {{ old('approval_status', $course->approval_status) === 'approved' ? 'selected' : '' }}>Approved (Badge Displayed)</option>
                            </select>
                            <div class="form-text text-danger">Only mark Approved once the registration is confirmed.</div>
                            @error('approval_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="registration_reference" class="form-label fw-bold">Official Registration Reference #</label>
                            <input type="text" name="registration_reference" id="registration_reference" class="form-control" value="{{ old('registration_reference', $course->registration_reference) }}" placeholder="e.g. SBTE/AFF/2023-914">
                        </div>

                        <div class="col-12">
                            <label for="approval_note" class="form-label fw-bold">Approval & Registration Specifics</label>
                            <input type="text" name="approval_note" id="approval_note" class="form-control" value="{{ old('approval_note', $course->approval_note) }}">
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-dark mb-3">Key Details & Campus Locations</h6>

                        <div class="col-md-4">
                            <label for="duration" class="form-label fw-bold">Course Duration</label>
                            <input type="text" name="duration" id="duration" class="form-control" value="{{ old('duration', $course->duration) }}">
                        </div>

                        <div class="col-md-4">
                            <label for="eligibility" class="form-label fw-bold">Eligibility Criteria</label>
                            <input type="text" name="eligibility" id="eligibility" class="form-control" value="{{ old('eligibility', $course->eligibility) }}">
                        </div>

                        <div class="col-md-4">
                            <label for="fee_note" class="form-label fw-bold">Fee & Installment Note</label>
                            <input type="text" name="fee_note" id="fee_note" class="form-control" value="{{ old('fee_note', $course->fee_note) }}">
                        </div>

                        <div class="col-12">
                            <label for="outcomes" class="form-label fw-bold">Learning Outcomes / Career Prospects</label>
                            <textarea name="outcomes" id="outcomes" rows="3" class="form-control">{{ old('outcomes', $course->outcomes) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Course Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 160px; height: 95px;" id="preview-course-img">
                                    @if($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}" alt="Current Image">
                                    @else
                                        <span class="text-muted small">Course Cover</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image" class="form-control image-upload-input" data-preview-target="preview-course-img" accept="image/*">
                                    <div class="form-text">Leave blank to retain current image.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Centre Checkboxes -->
                        <div class="col-12">
                            <label class="form-label fw-bold mb-2">Campus Locations Offering this Programme</label>
                            @php
                                $selectedCentres = $course->centres->pluck('id')->toArray();
                            @endphp
                            <div class="row g-2 border rounded p-3 bg-light">
                                @foreach($centres as $centre)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="centres[]" value="{{ $centre->id }}" id="centre_{{ $centre->id }}" {{ in_array($centre->id, old('centres', $selectedCentres)) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="centre_{{ $centre->id }}">
                                                <span class="badge {{ $centre->brand->isFsEducation() ? 'badge-brand-fs' : ($centre->brand->slug === 'aptech' ? 'badge-brand-aptech' : 'badge-brand-arena') }} me-1" style="font-size: 0.65rem;">
                                                    {{ $centre->brand->name }}
                                                </span>
                                                {{ $centre->name }} ({{ $centre->area }})
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Active for public catalog
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_featured">
                                    Feature on homepage
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Update Programme
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const brandSelect = document.getElementById('brand_id');
    const affilSelect = document.getElementById('affiliation_id');
    const warningBox = document.getElementById('franchise-warning-box');

    function checkBrandAffiliationRules() {
        const selectedOpt = brandSelect.options[brandSelect.selectedIndex];
        const slug = selectedOpt ? selectedOpt.getAttribute('data-slug') : '';

        if (slug === 'aptech' || slug === 'arena-multimedia') {
            affilSelect.value = '';
            affilSelect.disabled = true;
            warningBox.classList.remove('d-none');
        } else {
            affilSelect.disabled = false;
            warningBox.classList.add('d-none');
        }
    }

    brandSelect.addEventListener('change', checkBrandAffiliationRules);
    checkBrandAffiliationRules();
});
</script>
@endpush
@endsection
