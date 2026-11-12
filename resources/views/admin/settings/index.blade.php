@extends('layouts.admin')

@section('page_title', 'Site Settings & Brand Identity')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white p-0 border-bottom">
        <ul class="nav nav-tabs card-header-tabs m-0 border-0" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-4 py-3 fw-semibold" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                    <i class="bi bi-info-circle me-1"></i> General
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-semibold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                    <i class="bi bi-card-text me-1"></i> Company Profile
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-semibold" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">
                    <i class="bi bi-telephone me-1"></i> Contact Details
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-semibold" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                    <i class="bi bi-share me-1"></i> Social Media
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-semibold" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab">
                    <i class="bi bi-search me-1"></i> SEO
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-semibold" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing" type="button" role="tab">
                    <i class="bi bi-graph-up me-1"></i> Marketing & Analytics
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-semibold" id="display-tab" data-bs-toggle="tab" data-bs-target="#display" type="button" role="tab">
                    <i class="bi bi-sliders me-1"></i> Display Options
                </button>
            </li>
        </ul>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body p-4">
            <div class="tab-content" id="settingsTabContent">
                <!-- 1. General Tab -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="company_name" class="form-label fw-bold">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name', setting('company_name')) }}" required>
                            <div class="form-text">Primary brand of the entire group. e.g. "F.S. Education".</div>
                        </div>

                        <div class="col-md-6">
                            <label for="company_legal_name" class="form-label fw-bold">Legal Entity Name</label>
                            <input type="text" name="company_legal_name" id="company_legal_name" class="form-control" value="{{ old('company_legal_name', setting('company_legal_name')) }}">
                            <div class="form-text">Registered name used in copyright/agreements. e.g. "F.S. Education Network (Pvt) Ltd".</div>
                        </div>

                        <div class="col-md-6">
                            <label for="company_short_name" class="form-label fw-bold">Short Name / Acronym</label>
                            <input type="text" name="company_short_name" id="company_short_name" class="form-control" value="{{ old('company_short_name', setting('company_short_name')) }}">
                            <div class="form-text">Used on mobile badges. e.g. "FSE".</div>
                        </div>

                        <div class="col-md-6">
                            <label for="tagline" class="form-label fw-bold">Official Tagline</label>
                            <input type="text" name="tagline" id="tagline" class="form-control" value="{{ old('tagline', setting('tagline')) }}">
                            <div class="form-text">e.g. "Learn Today. Lead Tomorrow."</div>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-dark mb-3">Brand Marks & Logos</h6>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Parent Brand Logo (F.S. Education)</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" id="preview-site-logo">
                                    @if(setting('site_logo'))
                                        <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="Site Logo">
                                    @else
                                        <span class="text-muted small">No Logo</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="site_logo" class="form-control image-upload-input" data-preview-target="preview-site-logo" accept="image/*">
                                    <div class="form-text">Recommended size: 500x160px PNG or WebP. Transparent background.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Browser Favicon</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 64px; height: 64px;" id="preview-site-favicon">
                                    @if(setting('site_favicon'))
                                        <img src="{{ asset('storage/' . setting('site_favicon')) }}" alt="Favicon">
                                    @else
                                        <span class="text-muted small">Icon</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="site_favicon" class="form-control image-upload-input" data-preview-target="preview-site-favicon" accept="image/x-icon,image/png,image/webp">
                                    <div class="form-text">Recommended size: 32x32px or 64x64px.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Aptech Franchise Network Logo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" id="preview-aptech-logo">
                                    @if(setting('aptech_logo'))
                                        <img src="{{ asset('storage/' . setting('aptech_logo')) }}" alt="Aptech Logo">
                                    @else
                                        <span class="text-muted small">No Logo</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="aptech_logo" class="form-control image-upload-input" data-preview-target="preview-aptech-logo" accept="image/*">
                                    <div class="form-text">Franchisor approved logo for network display strips.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Arena Multimedia Franchise Logo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" id="preview-arena-logo">
                                    @if(setting('arena_logo'))
                                        <img src="{{ asset('storage/' . setting('arena_logo')) }}" alt="Arena Logo">
                                    @else
                                        <span class="text-muted small">No Logo</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="arena_logo" class="form-control image-upload-input" data-preview-target="preview-arena-logo" accept="image/*">
                                    <div class="form-text">Franchisor approved logo for network display strips.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Company Profile Tab -->
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="intro" class="form-label fw-bold">Group Introduction</label>
                            <textarea name="intro" id="intro" rows="3" class="form-control">{{ old('intro', setting('intro')) }}</textarea>
                            <div class="form-text">Appears in homepage overview and footer summary.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="vision" class="form-label fw-bold">Vision Statement</label>
                            <textarea name="vision" id="vision" rows="3" class="form-control">{{ old('vision', setting('vision')) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="mission" class="form-label fw-bold">Mission Statement</label>
                            <textarea name="mission" id="mission" rows="3" class="form-control">{{ old('mission', setting('mission')) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="registration_statement" class="form-label fw-bold text-primary">Registration Transparency Statement</label>
                            <textarea name="registration_statement" id="registration_statement" rows="3" class="form-control">{{ old('registration_statement', setting('registration_statement')) }}</textarea>
                            <div class="form-text">Mandatory statement explaining that SBTE/NAVTTC registrations apply to specific centres and approved programmes, never blanket site-wide claims.</div>
                        </div>

                        <div class="col-12">
                            <label for="founder_message" class="form-label fw-bold">Message from Founder / Leadership</label>
                            <textarea name="founder_message" id="founder_message" rows="4" class="form-control">{{ old('founder_message', setting('founder_message')) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 3. Contact Details Tab -->
                <div class="tab-pane fade" id="contact" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold">Primary Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', setting('phone')) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="phone_secondary" class="form-label fw-bold">Secondary Phone</label>
                            <input type="text" name="phone_secondary" id="phone_secondary" class="form-control" value="{{ old('phone_secondary', setting('phone_secondary')) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label fw-bold text-success"><i class="bi bi-whatsapp"></i> WhatsApp Number (with country code)</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ old('whatsapp', setting('whatsapp')) }}" placeholder="923001234567">
                            <div class="form-text">Used for the floating WhatsApp button and click-to-chat inquiry buttons. Do not include "+" or dashes.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">General Contact Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', setting('email')) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="inquiry_notification_email" class="form-label fw-bold text-primary">Inquiry Notification Email</label>
                            <input type="email" name="inquiry_notification_email" id="inquiry_notification_email" class="form-control" value="{{ old('inquiry_notification_email', setting('inquiry_notification_email')) }}">
                            <div class="form-text">New website admissions and partner requests will be routed to this recipient.</div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label fw-bold">Head Office Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', setting('address')) }}">
                        </div>
                    </div>
                </div>

                <!-- 4. Social Media Tab -->
                <div class="tab-pane fade" id="social" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="facebook_url" class="form-label fw-bold"><i class="bi bi-facebook text-primary me-1"></i> Facebook Page URL</label>
                            <input type="url" name="facebook_url" id="facebook_url" class="form-control" value="{{ old('facebook_url', setting('facebook_url')) }}" placeholder="https://facebook.com/fseducation">
                        </div>

                        <div class="col-md-6">
                            <label for="instagram_url" class="form-label fw-bold"><i class="bi bi-instagram text-danger me-1"></i> Instagram Profile URL</label>
                            <input type="url" name="instagram_url" id="instagram_url" class="form-control" value="{{ old('instagram_url', setting('instagram_url')) }}" placeholder="https://instagram.com/fseducation">
                        </div>

                        <div class="col-md-6">
                            <label for="linkedin_url" class="form-label fw-bold"><i class="bi bi-linkedin text-info me-1"></i> LinkedIn Page URL</label>
                            <input type="url" name="linkedin_url" id="linkedin_url" class="form-control" value="{{ old('linkedin_url', setting('linkedin_url')) }}" placeholder="https://linkedin.com/company/fseducation">
                        </div>

                        <div class="col-md-6">
                            <label for="youtube_url" class="form-label fw-bold"><i class="bi bi-youtube text-danger me-1"></i> YouTube Channel URL</label>
                            <input type="url" name="youtube_url" id="youtube_url" class="form-control" value="{{ old('youtube_url', setting('youtube_url')) }}" placeholder="https://youtube.com/@fseducation">
                        </div>

                        <div class="col-md-6">
                            <label for="tiktok_url" class="form-label fw-bold"><i class="bi bi-tiktok text-dark me-1"></i> TikTok Profile URL</label>
                            <input type="url" name="tiktok_url" id="tiktok_url" class="form-control" value="{{ old('tiktok_url', setting('tiktok_url')) }}" placeholder="https://tiktok.com/@fseducation">
                        </div>

                        <div class="col-md-6">
                            <label for="twitter_url" class="form-label fw-bold"><i class="bi bi-twitter-x text-dark me-1"></i> X (Twitter) URL</label>
                            <input type="url" name="twitter_url" id="twitter_url" class="form-control" value="{{ old('twitter_url', setting('twitter_url')) }}" placeholder="https://x.com/fseducation">
                        </div>
                    </div>
                </div>

                <!-- 5. SEO Defaults Tab -->
                <div class="tab-pane fade" id="seo" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="meta_title" class="form-label fw-bold">Default Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', setting('meta_title')) }}">
                            <div class="form-text">Used on pages that do not define a custom title tag. Recommended 50-60 characters.</div>
                        </div>

                        <div class="col-12">
                            <label for="meta_description" class="form-label fw-bold">Default Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control">{{ old('meta_description', setting('meta_description')) }}</textarea>
                            <div class="form-text">Default summary for search engine snippet and social card fallbacks. Recommended 150-160 characters.</div>
                        </div>

                        <div class="col-12">
                            <label for="meta_keywords" class="form-label fw-bold">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords', setting('meta_keywords')) }}">
                            <div class="form-text">Comma-separated keywords.</div>
                        </div>
                    </div>
                </div>

                <!-- 6. Marketing & Analytics Tab -->
                <div class="tab-pane fade" id="marketing" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="meta_pixel_id" class="form-label fw-bold text-primary"><i class="bi bi-meta me-1"></i> Meta Pixel ID (Facebook / Instagram)</label>
                            <input type="text" name="meta_pixel_id" id="meta_pixel_id" class="form-control font-monospace" value="{{ old('meta_pixel_id', setting('meta_pixel_id')) }}" placeholder="e.g. 123456789012345">
                            <div class="form-text">Fires PageView, ViewContent (courses/MOUs), and Lead events on form submission.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="google_analytics_id" class="form-label fw-bold text-warning"><i class="bi bi-google me-1"></i> Google Analytics 4 Measurement ID</label>
                            <input type="text" name="google_analytics_id" id="google_analytics_id" class="form-control font-monospace" value="{{ old('google_analytics_id', setting('google_analytics_id')) }}" placeholder="G-XXXXXXXXXX">
                            <div class="form-text">e.g. G-12345ABCDE. Loaded only when configured.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Default Social Share Image (Open Graph / Twitter Card)</label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="image-preview-box" style="width: 200px; height: 105px;" id="preview-default-og">
                                    @if(setting('default_og_image'))
                                        <img src="{{ asset('storage/' . setting('default_og_image')) }}" alt="Default OG Image">
                                    @else
                                        <span class="text-muted small">1200 x 630 px</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="default_og_image" class="form-control image-upload-input" data-preview-target="preview-default-og" accept="image/*">
                                    <div class="form-text">Optimal size: 1200 x 630 pixels. Appears when sharing links on Facebook, Instagram, WhatsApp, and LinkedIn.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="show_cookie_notice" name="show_cookie_notice" value="1" {{ setting('show_cookie_notice', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="show_cookie_notice">
                                    Enable Cookie Consent Notice for Tracking Scripts
                                </label>
                                <div class="form-text ms-5">
                                    If enabled, Meta Pixel and Google Analytics tracking scripts will only execute after the user accepts the consent banner.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7. Display Options Tab -->
                <div class="tab-pane fade" id="display" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border mb-3">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="show_registration_references" name="show_registration_references" value="1" {{ setting('show_registration_references', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="show_registration_references">
                                    Show Statutory Registration References on Approved Courses
                                </label>
                                <div class="form-text ms-5">
                                    When checked, approved F.S. Education courses will display their official registration reference code (e.g. "SBTE/AFF/2023-914") next to the approval badge.
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="show_exact_mou_discounts" name="show_exact_mou_discounts" value="1" {{ setting('show_exact_mou_discounts', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="show_exact_mou_discounts">
                                    Show Exact Discount Values on Public Course Cards
                                </label>
                                <div class="form-text ms-5">
                                    When unchecked, course cards will display a generic "Partner Discounts Available" notice rather than exact figures until the user views the MOU detail page.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light p-3 text-end border-top">
            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                <i class="bi bi-check-circle me-1"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
