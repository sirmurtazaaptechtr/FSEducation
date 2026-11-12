@props(['partner'])

<div class="card h-100 shadow-sm border-0 hover-shadow mou-item">
    <div class="card-body d-flex flex-column p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-3">
                @if($partner->logo)
                    <img src="{{ asset('storage/' . $partner->logo) }}"
                         alt="{{ $partner->name }}"
                         style="width: 52px; height: 52px; object-fit: contain;"
                         class="rounded border p-1 bg-white">
                @else
                    <div class="rounded bg-light border d-flex align-items-center justify-content-center text-primary fw-bold"
                         style="width: 52px; height: 52px;">
                        <i class="bi bi-handshake fs-4"></i>
                    </div>
                @endif
                <div>
                    <h5 class="fw-bold mb-0 text-dark">
                        <a href="{{ route('mou-partners.show', $partner->slug) }}" class="text-decoration-none text-dark hover-primary">
                            {{ $partner->name }}
                        </a>
                    </h5>
                    <span class="badge bg-light text-secondary border small text-capitalize">
                        {{ $partner->organization_type }}
                    </span>
                </div>
            </div>

            @if($partner->is_featured)
                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning">
                    <i class="bi bi-star-fill me-1"></i> Featured
                </span>
            @endif
        </div>

        {{-- Discount highlight strip --}}
        <div class="bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded p-3 mb-3 text-center">
            <span class="fw-bold fs-5 d-block">{{ $partner->discount_label ?: 'Agreed Student Discount' }}</span>
            @if($partner->referral_code)
                <small class="text-muted d-block mt-1 font-monospace">Referral Code: <strong class="text-dark">{{ $partner->referral_code }}</strong></small>
            @endif
        </div>

        @if($partner->short_description)
            <p class="text-muted small mb-3 flex-grow-1">
                {{ Str::limit($partner->short_description, 110) }}
            </p>
        @else
            <div class="flex-grow-1"></div>
        @endif

        {{-- Brand applicability warning / badges (Business Rule 7: defaults to none) --}}
        <div class="mb-3 small">
            <div class="text-muted mb-1"><i class="bi bi-check2-circle text-success me-1"></i> Applicable Brands:</div>
            <div class="d-flex flex-wrap gap-1">
                @forelse($partner->brands as $b)
                    <x-brand-badge :brand="$b" class="small" />
                @empty
                    <span class="badge bg-secondary-subtle text-secondary border">Check with Campus Admission</span>
                @endforelse
            </div>
        </div>

        {{-- Validity date info --}}
        <div class="pt-2 border-top small text-muted d-flex justify-content-between align-items-center mb-3">
            <span><i class="bi bi-calendar-check me-1 text-primary"></i> Validity:</span>
            <span class="fw-medium text-dark">
                @if($partner->valid_until)
                    Until {{ $partner->valid_until->format('M d, Y') }}
                @else
                    Active Partnership
                @endif
            </span>
        </div>

        <div class="mt-auto">
            <a href="{{ route('mou-partners.show', $partner->slug) }}" class="btn btn-outline-primary btn-sm w-100 fw-semibold">
                View Terms & How to Avail <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
