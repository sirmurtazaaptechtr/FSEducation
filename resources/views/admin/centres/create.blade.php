@extends('layouts.admin')

@section('page_title', 'Add Campus Centre')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-plus-circle me-2 text-primary"></i> Create Network Campus</h6>
            </div>

            <form method="POST" action="{{ route('admin.centres.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="brand_id" class="form-label fw-bold">Operating Brand <span class="text-danger">*</span></label>
                            <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }} ({{ $brand->isFsEducation() ? 'Parent' : 'Franchise' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Every centre belongs to exactly one brand.</div>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Centre Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Aptech North Nazimabad Centre">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="area" class="form-label fw-bold">Area / District</label>
                            <input type="text" name="area" id="area" class="form-control" value="{{ old('area') }}" placeholder="e.g. North Nazimabad">
                        </div>

                        <div class="col-md-6">
                            <label for="city" class="form-label fw-bold">City</label>
                            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', 'Karachi') }}">
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label fw-bold">Full Campus Physical Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" placeholder="Plot / Block / Main Road details">
                        </div>

                        <div class="col-md-4">
                            <label for="phone" class="form-label fw-bold">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="+92 21 3498 xxxx">
                        </div>

                        <div class="col-md-4">
                            <label for="whatsapp" class="form-label fw-bold text-success"><i class="bi bi-whatsapp"></i> WhatsApp Number</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ old('whatsapp') }}" placeholder="923001234567">
                        </div>

                        <div class="col-md-4">
                            <label for="email" class="form-label fw-bold">Centre Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="campus@fseducation.pk">
                        </div>

                        <div class="col-12">
                            <label for="map_url" class="form-label fw-bold">Google Maps Embed or Link URL</label>
                            <input type="url" name="map_url" id="map_url" class="form-control" value="{{ old('map_url') }}" placeholder="https://maps.google.com/...">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Centre Cover Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 160px; height: 95px;" id="preview-centre-cover">
                                    <span class="text-muted small">Cover</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="cover_image" class="form-control image-upload-input" data-preview-target="preview-centre-cover" accept="image/*">
                                    <div class="form-text">Recommended size: 1200 x 800 pixels.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="short_description" class="form-label fw-bold">Short Overview</label>
                            <textarea name="short_description" id="short_description" rows="2" class="form-control" placeholder="Brief campus summary">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">Detailed Campus Description & Facilities</label>
                            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Details about computer labs, classrooms, student amenities...">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="registration_note" class="form-label fw-bold text-primary">Registration Transparency Note</label>
                            <input type="text" name="registration_note" id="registration_note" class="form-control" value="{{ old('registration_note') }}" placeholder="e.g. Centre recognized by SBTE for designated technical diplomas.">
                            <div class="form-text">Explains exact registration claims for this campus.</div>
                        </div>

                        <!-- Courses offered here -->
                        <div class="col-12">
                            <label class="form-label fw-bold mb-2">Programmes & Courses Offered at this Centre</label>
                            <div class="row g-2 border rounded p-3 bg-light" style="max-height: 220px; overflow-y: auto;">
                                @forelse($courses as $course)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="courses[]" value="{{ $course->id }}" id="course_{{ $course->id }}" {{ in_array($course->id, old('courses', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="course_{{ $course->id }}">
                                                <span class="badge {{ $course->brand->isFsEducation() ? 'badge-brand-fs' : ($course->brand->slug === 'aptech' ? 'badge-brand-aptech' : 'badge-brand-arena') }} me-1" style="font-size: 0.65rem;">
                                                    {{ $course->brand->name }}
                                                </span>
                                                {{ $course->title }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted small">No courses registered yet.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Additional Gallery Photos -->
                        <div class="col-12">
                            <label class="form-label fw-bold mb-1">Add Campus Photos (Optional)</label>
                            <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*">
                            <div class="form-text">Select one or multiple images for the campus photo gallery.</div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Publish this campus centre publicly
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.centres.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Save Centre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
