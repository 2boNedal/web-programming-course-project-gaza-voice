<?php

namespace App\Http\Requests\Admin;

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
        $tag = $this->route('tag');
        $tagId = $tag ? $tag->id : null;

        return [
            'name' => ['required', 'string', 'max:80', Rule::unique('tags', 'name')->ignore($tagId)],
        ];
    }
}

