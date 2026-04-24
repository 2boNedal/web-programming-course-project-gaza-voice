<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tagId = (int) $this->route('tag');

        return [
            'name' => [
                'required',
                'string',
                'max:80',
                Rule::unique('tags', 'name')->ignore($tagId),
            ],
        ];
    }
}
