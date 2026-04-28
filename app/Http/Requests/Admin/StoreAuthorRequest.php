<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:191', 'unique:authors,email'],
            'password' => ['required', 'string', 'min:3'],
            'bio' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp'],
        ];
    }
}

