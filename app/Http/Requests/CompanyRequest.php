<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'category_id' => 'nullable|exists:company_categories,id',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'status' => 'required',
        ];

        // For PUT requests, make some fields optional
        if ($this->isMethod('PUT')) {
            $rules['title'] = 'sometimes|string|max:255';
            $rules['status'] = 'sometimes';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        }

        return $rules;
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'category_id.exists' => 'The selected category is invalid.',
            'title.required' => 'The title field is required.',
            'title.max' => 'The title cannot be longer than 255 characters.',
            'image.image' => 'The image must be a valid image file.',
            'image.mimes' => 'The image must be of type: jpeg, png, or jpg.',
            'image.max' => 'The image size should not exceed 2MB.',
            'description.max' => 'The description cannot be longer than 1000 characters.',
            'status.required' => 'The status field is required.',
        ];
    }
}
