<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('slug') && $this->filled('name')) {
            $this->merge([
                'slug' => Str::slug($this->input('name')),
            ]);
        }
    }

    public function rules(): array
    {
        $categoryId = (int) $this->route('category');

        return [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
            'slug' => [
                'required',
                'string',
                'max:160',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],
        ];
    }
}
