@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'url' => null,
    'type' => 'website'
])

@php
    $siteName = setting('company_name', 'F.S. Education');
    $metaTitle = $title ? "{$title} | {$siteName}" : setting('meta_title', $siteName);
    $metaDescription = $description ?: setting('meta_description', 'F.S. Education is a premier educational group in Karachi running centres under its own brand as well as Aptech and Arena Multimedia franchises.');
    $currentUrl = $url ?: url()->current();

    // Determine 1200x630 OG image with fallbacks
    $imageUrl = null;
    if ($image) {
        $imageUrl = str_starts_with($image, 'http') ? $image : asset('storage/' . $image);
    } elseif (setting('default_og_image')) {
        $imageUrl = asset('storage/' . setting('default_og_image'));
    } else {
        $imageUrl = asset('assets/images/default-og.jpg');
    }
@endphp

<!-- Canonical URL -->
<link rel="canonical" href="{{ $currentUrl }}">

<!-- Open Graph / Facebook / WhatsApp -->
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $currentUrl }}">
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $imageUrl }}">
