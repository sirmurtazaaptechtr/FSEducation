@props([
    'title' => '',
    'url' => null,
])

@php
    $shareUrl = $url ?: url()->current();
    $shareTitle = $title ?: setting('company_name', 'F.S. Education');
    $encodedUrl = urlencode($shareUrl);
    $encodedTitle = urlencode($shareTitle);
@endphp

<div class="share-buttons-wrapper d-inline-flex align-items-center gap-2">
    <span class="small text-muted fw-semibold me-1"><i class="bi bi-share me-1"></i> Share:</span>

    <!-- WhatsApp Share -->
    <a href="https://api.whatsapp.com/send?text={{ $encodedTitle }}%20{{ $encodedUrl }}"
       target="_blank"
       rel="noopener"
       class="btn btn-sm btn-outline-success rounded-circle d-inline-flex align-items-center justify-content-center"
       style="width: 34px; height: 34px;"
       title="Share on WhatsApp"
       aria-label="Share on WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- Facebook Share -->
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}"
       target="_blank"
       rel="noopener"
       class="btn btn-sm btn-outline-primary rounded-circle d-inline-flex align-items-center justify-content-center"
       style="width: 34px; height: 34px;"
       title="Share on Facebook"
       aria-label="Share on Facebook">
        <i class="bi bi-facebook"></i>
    </a>

    <!-- LinkedIn Share -->
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}"
       target="_blank"
       rel="noopener"
       class="btn btn-sm btn-outline-info rounded-circle d-inline-flex align-items-center justify-content-center"
       style="width: 34px; height: 34px;"
       title="Share on LinkedIn"
       aria-label="Share on LinkedIn">
        <i class="bi bi-linkedin"></i>
    </a>

    <!-- Copy Link Button with Vanilla JS feedback -->
    <button type="button"
            class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center btn-copy-link"
            style="width: 34px; height: 34px;"
            data-url="{{ $shareUrl }}"
            title="Copy link to clipboard"
            aria-label="Copy link">
        <i class="bi bi-link-45deg"></i>
    </button>
</div>

