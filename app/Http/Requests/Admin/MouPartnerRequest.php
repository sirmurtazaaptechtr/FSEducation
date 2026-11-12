<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MouPartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && ($this->user()->isAdmin() || $this->user()->isEditor());
    }

    public function rules(): array
    {
        $partnerId = $this->route('mou_partner') ? $this->route('mou_partner')->id : null;

        return [
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('mou_partners', 'slug')->ignore($partnerId)],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'organization_type' => ['required', 'in:corporate,school,college,university,ngo,association,other'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'signed_on' => ['nullable', 'date'],
            'valid_from' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date', 'after_or_equal:valid_from'],
            'discount_type' => ['required', 'in:percentage,fixed,custom_text'],
            'discount_value' => ['nullable', 'string', 'max:50'],
            'discount_label' => ['required', 'string', 'max:150'],
            'terms' => ['nullable', 'string'],
            'how_to_avail' => ['nullable', 'string'],
            'referral_code' => ['nullable', 'string', 'max:50'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'brands' => ['nullable', 'array'],
            'brands.*' => ['exists:brands,id'],
            'courses' => ['nullable', 'array'],
            'courses.*' => ['exists:courses,id'],
        ];
    }
}

