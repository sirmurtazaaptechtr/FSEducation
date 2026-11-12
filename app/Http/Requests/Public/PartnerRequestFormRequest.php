<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequestFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:3000'],
            'company_hp' => ['nullable', 'max:0'], // Honeypot field must be empty
        ];
    }

    public function messages(): array
    {
        return [
            'organization_name.required' => 'Please provide the name of your organization or institution.',
            'contact_person.required' => 'Please provide the focal contact person name.',
            'phone.required' => 'Please provide a valid contact phone number.',
            'email.required' => 'Please provide an official contact email address.',
            'company_hp.max' => 'Spam bot submission detected.',
        ];
    }
}

