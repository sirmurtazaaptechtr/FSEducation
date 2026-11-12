@props(['course'])

@php
    $brandSlug = $course->brand?->slug ?? '';
    $cardBrandClass = match($brandSlug) {
        'fs-education' => 'card-brand-fs',
        'aptech' => 'card-brand-aptech',
        'arena-multimedia' => 'card-brand-arena',
        default => ''
    };
@endphp

<div class="card h-100 shadow-sm border-0 hover-shadow {{ $cardBrandClass }} course-item"
     data-brand="{{ $brandSlug }}"
     data-category="{{ $course->category?->slug ?? '' }}"
     data-affiliation="{{ $brandSlug === 'fs-education' && $course->affiliation ? $course->affiliation->short_name : '' }}"
     data-title="{{ strtolower($course->title) }}"
     data-centres="{{ $course->centres->pluck('id')->implode(',') }}">
    
    @if($course->image)
        <div class="position-relative overflow-hidden" style="height: 180px;">
            <img src="{{ asset('storage/' . $course->image) }}"
                 alt="{{ $course->title }}"
                 class="w-100 h-100 object-fit-cover"
                 loading="lazy">
            @if($course->is_featured)
                <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark shadow-sm">
                    <i class="bi bi-star-fill me-1"></i> Featured
                </span>
            @endif
        </div>
    @endif

    <div class="card-body d-flex flex-column p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
            <x-brand-badge :brand="$course->brand" />
            
            @if($course->category)
                <span class="badge bg-light text-secondary border small">{{ $course->category->name }}</span>
            @endif
        </div>

        <h5 class="card-title fw-bold text-dark mb-2">
            <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none text-dark hover-primary">
                {{ $course->title }}
            </a>
        </h5>

        @if($course->short_description)
            <p class="card-text text-muted small mb-3 flex-grow-1">
                {{ Str::limit($course->short_description, 110) }}
            </p>
        @else
            <div class="flex-grow-1"></div>
        @endif

        {{-- Strictly enforce business rules for affiliations and approvals --}}
        <div class="d-flex flex-wrap gap-1 mb-3">
            {{-- Affiliation tag: STRICTLY ONLY for F.S. Education courses, NEVER for Aptech or Arena --}}
            @if($brandSlug === 'fs-education' && $course->affiliation)
                <span class="badge bg-info-subtle text-info-emphasis border border-info" title="External Affiliation">
                    <i class="bi bi-award me-1"></i> {{ $course->affiliation->short_name }}
                </span>
            @endif

            {{-- Approval badge: STRICTLY ONLY when explicitly approved by admin --}}
            @if($course->approval_status === 'approved')
                <span class="badge bg-success-subtle text-success border border-success" title="Approved Programme">
                    <i class="bi bi-patch-check-fill me-1"></i> Recognized / Approved
                </span>
            @endif
        </div>

        {{-- Meta details --}}
        <div class="pt-2 border-top small text-muted d-flex justify-content-between align-items-center mb-3">
            @if($course->duration)
                <span><i class="bi bi-clock me-1 text-primary"></i> {{ $course->duration }}</span>
            @endif
            @if($course->eligibility)
                <span><i class="bi bi-mortarboard me-1 text-primary"></i> {{ $course->eligibility }}</span>
            @endif
        </div>

        {{-- Offered at Centres --}}
        @if($course->centres && $course->centres->isNotEmpty())
            <div class="mb-3 small">
                <span class="text-muted"><i class="bi bi-geo-alt me-1"></i> Offered at:</span>
                <span class="text-dark fw-medium">{{ $course->centres->pluck('name')->take(2)->implode(', ') }}{{ $course->centres->count() > 2 ? ' +' . ($course->centres->count() - 2) . ' more' : '' }}</span>
            </div>
        @endif

        <div class="mt-auto">
            <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-outline-primary btn-sm w-100 fw-semibold">
                View Programme Details <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
