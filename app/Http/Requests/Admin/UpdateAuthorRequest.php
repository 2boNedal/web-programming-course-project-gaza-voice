<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $author = $this->route('author');
        $authorId = $author ? $author->id : null;

        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:191', Rule::unique('authors', 'email')->ignore($authorId)],
            'bio' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
        ];
    }
}

