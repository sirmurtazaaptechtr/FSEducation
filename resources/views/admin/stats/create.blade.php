@extends('layouts.admin')

@section('page_title', 'Create Key Figure')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-plus-circle me-2 text-primary"></i> Add Key Figure Stat</h6>
            </div>

            <form method="POST" action="{{ route('admin.stats.store') }}">
                @csrf
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="label" class="form-label fw-bold">Metric Label <span class="text-danger">*</span></label>
                            <input type="text" name="label" id="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label') }}" required placeholder="e.g. Students Trained">
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-7">
                            <label for="value" class="form-label fw-bold">Numeric Value <span class="text-danger">*</span></label>
                            <input type="text" name="value" id="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required placeholder="e.g. 25,000">
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5">
                            <label for="suffix" class="form-label fw-bold">Suffix</label>
                            <input type="text" name="suffix" id="suffix" class="form-control" value="{{ old('suffix') }}" placeholder="e.g. + or %">
                            <div class="form-text">e.g. "+" or "%"</div>
                        </div>

                        <div class="col-12">
                            <label for="icon" class="form-label fw-bold">Bootstrap Icon Class</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-award"></i></span>
                                <input type="text" name="icon" id="icon" class="form-control font-monospace" value="{{ old('icon', 'bi-mortarboard-fill') }}" placeholder="bi-mortarboard-fill">
                            </div>
                            <div class="form-text">Choose any Bootstrap 5 icon class (e.g. <code>bi-mortarboard-fill</code>, <code>bi-building</code>, <code>bi-graph-up-arrow</code>, <code>bi-briefcase</code>).</div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Display this metric on the public site
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.stats.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Save Key Figure
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

