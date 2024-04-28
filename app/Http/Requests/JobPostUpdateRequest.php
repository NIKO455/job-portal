<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => ['required', 'string', 'max:200', 'min:5'],
            "category_id" => ['required', 'exists:categories,id'],
            "job_type_id" => ['required', 'exists:job_types,id'],
            "vacancy" => ['required', 'integer', 'min:1'],
            "salary" => ['nullable', 'integer', 'min:1'],
            "location" => ['required', 'string'],
            "description" => ['required', 'string'],
            "benefits" => ['nullable', 'string'],
            "responsibility" => ['nullable', 'string'],
            "qualification" => ['nullable', 'string'],
            "keywords" => ['nullable', 'string'],
            "experience" => ['required', 'string'],
            "company_name" => ['required', 'string'],
            "company_location" => ['nullable', 'string'],
            "company_website" => ['nullable', 'string'],
        ];
    }
}
