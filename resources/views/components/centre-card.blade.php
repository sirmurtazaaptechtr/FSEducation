@props(['centre'])

@php
    $brandSlug = $centre->brand?->slug ?? '';
    $cardBrandClass = match($brandSlug) {
        'fs-education' => 'card-brand-fs',
        'aptech' => 'card-brand-aptech',
        'arena-multimedia' => 'card-brand-arena',
        default => ''
    };
@endphp

<div class="card h-100 shadow-sm border-0 hover-shadow {{ $cardBrandClass }} centre-item"
     data-brand="{{ $brandSlug }}"
     data-area="{{ strtolower($centre->area) }}"
     data-city="{{ strtolower($centre->city) }}">

    <div class="position-relative overflow-hidden" style="height: 200px;">
        @if($centre->cover_image)
            <img src="{{ asset('storage/' . $centre->cover_image) }}"
                 alt="{{ $centre->name }}"
                 class="w-100 h-100 object-fit-cover"
                 loading="lazy">
        @else
            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                <i class="bi bi-building fs-1 opacity-50"></i>
            </div>
        @endif
        <div class="position-absolute top-0 start-0 m-3">
            <x-brand-badge :brand="$centre->brand" />
        </div>
    </div>

    <div class="card-body d-flex flex-column p-4">
        <h5 class="card-title fw-bold text-dark mb-1">
            <a href="{{ route('centres.show', $centre->slug) }}" class="text-decoration-none text-dark hover-primary">
                {{ $centre->name }}
            </a>
        </h5>

        <div class="text-muted small mb-3">
            <i class="bi bi-geo-alt text-primary me-1"></i> {{ $centre->area }}, {{ $centre->city }}
        </div>

        @if($centre->short_description)
            <p class="card-text text-muted small mb-3 flex-grow-1">
                {{ Str::limit($centre->short_description, 110) }}
            </p>
        @else
            <div class="flex-grow-1"></div>
        @endif

        {{-- Contact details --}}
        <div class="pt-2 border-top small text-muted mb-3">
            @if($centre->phone)
                <div class="mb-1">
                    <a href="tel:{{ $centre->phone }}" class="text-decoration-none text-muted">
                        <i class="bi bi-telephone text-primary me-2"></i>{{ $centre->phone }}
                    </a>
                </div>
            @endif
            @if($centre->whatsapp)
                <div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $centre->whatsapp) }}?text={{ urlencode('Hello, I am inquiring about ' . $centre->name) }}"
                       target="_blank" rel="noopener"
                       class="text-decoration-none text-success">
                        <i class="bi bi-whatsapp me-2"></i>{{ $centre->whatsapp }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Registration Note Preview if applicable --}}
        @if($centre->registration_note)
            <div class="p-2 bg-light border rounded small text-muted mb-3" style="font-size: 0.75rem;">
                <i class="bi bi-info-circle text-primary me-1"></i> {{ Str::limit($centre->registration_note, 80) }}
            </div>
        @endif

        <div class="mt-auto d-flex gap-2">
            <a href="{{ route('centres.show', $centre->slug) }}" class="btn btn-primary btn-sm flex-grow-1 fw-semibold">
                View Campus <i class="bi bi-arrow-right ms-1"></i>
            </a>
            @if($centre->map_url)
                <a href="{{ $centre->map_url }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm" title="View Location Map">
                    <i class="bi bi-geo-alt"></i>
                </a>
            @endif
        </div>
    </div>
</div>
