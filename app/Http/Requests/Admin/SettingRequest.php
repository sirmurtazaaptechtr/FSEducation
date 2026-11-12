<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            // General Company Information
            'company_name' => ['nullable', 'string', 'max:150'],
            'company_legal_name' => ['nullable', 'string', 'max:200'],
            'company_short_name' => ['nullable', 'string', 'max:50'],
            'tagline' => ['nullable', 'string', 'max:255'],

            // Company Profile
            'intro' => ['nullable', 'string', 'max:2000'],
            'vision' => ['nullable', 'string', 'max:1000'],
            'mission' => ['nullable', 'string', 'max:1000'],
            'registration_statement' => ['nullable', 'string', 'max:2000'],
            'founder_message' => ['nullable', 'string', 'max:3000'],

            // Contact Information
            'phone' => ['nullable', 'string', 'max:50'],
            'phone_secondary' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'inquiry_notification_email' => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string', 'max:300'],

            // Social Media
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],

            // SEO Defaults
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],

            // Marketing & Analytics
            'meta_pixel_id' => ['nullable', 'string', 'max:100'],
            'google_analytics_id' => ['nullable', 'string', 'max:100'],
            'show_cookie_notice' => ['nullable', 'in:0,1'],

            // Display Flags
            'show_registration_references' => ['nullable', 'in:0,1'],
            'show_exact_mou_discounts' => ['nullable', 'in:0,1'],

            // Image Uploads
            'site_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'site_favicon' => ['nullable', 'mimes:jpg,jpeg,png,webp,ico', 'max:2048'],
            'aptech_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'arena_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'default_og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}

