<?php

namespace App\Http\Requests\Admin;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && ($this->user()->isAdmin() || $this->user()->isEditor());
    }

    public function rules(): array
    {
        $courseId = $this->route('course') ? $this->route('course')->id : null;

        return [
            'brand_id' => ['required', 'exists:brands,id'],
            'course_category_id' => ['required', 'exists:course_categories,id'],
            'affiliation_id' => ['nullable', 'exists:affiliations,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('courses', 'slug')->ignore($courseId)],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'duration' => ['nullable', 'string', 'max:100'],
            'eligibility' => ['nullable', 'string', 'max:200'],
            'fee_note' => ['nullable', 'string', 'max:200'],
            'outcomes' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'approval_status' => ['required', 'in:none,pending,approved'],
            'registration_reference' => ['nullable', 'string', 'max:100'],
            'approval_note' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'centres' => ['nullable', 'array'],
            'centres.*' => ['exists:centres,id'],
        ];
    }

    /**
     * Configure the validator instance with strict franchisor business rules.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $brandId = $this->input('brand_id');
            $affiliationId = $this->input('affiliation_id');

            if ($brandId && $affiliationId) {
                $brand = Brand::find($brandId);
                if ($brand && $brand->slug !== 'fs-education') {
                    $validator->errors()->add(
                        'affiliation_id',
                        'Affiliations (SBTE/NAVTTC) are strictly restricted to F.S. Education programmes. Franchise courses under ' . $brand->name . ' cannot carry external affiliation tags.'
                    );
                }
            }
        });
    }
}

