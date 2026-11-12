<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class InquiryFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'centre_id' => ['nullable', 'exists:centres,id'],
            'mou_partner_id' => ['nullable', 'exists:mou_partners,id'],
            'referral_code_entered' => ['nullable', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:2000'],
            'website_hp' => ['nullable', 'max:0'], // Honeypot field must be empty
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'phone.required' => 'Please provide a contact phone number.',
            'email.email' => 'Please provide a valid email address.',
            'website_hp.max' => 'Spam bot submission detected.',
        ];
    }
}

