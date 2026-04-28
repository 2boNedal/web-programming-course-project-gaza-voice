<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $slug = trim((string) $this->input('slug', ''));

        if ($slug === '') {
            $slug = $this->generateSlugFromTitle((string) $this->input('title', ''));
        }

        $this->merge([
            'slug' => $slug,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:220'],
            'slug' => ['required', 'string', 'max:255', 'unique:articles,slug'],
            'body' => ['required', 'string'],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
            ],
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['integer', 'distinct', 'exists:tags,id'],
            'cover_image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp'],
        ];
    }

    private function generateSlugFromTitle(string $title): string
    {
        $title = mb_strtolower(trim($title), 'UTF-8');
        $title = preg_replace('/[^\p{Arabic}\p{L}\p{N}\s-]+/u', '', $title) ?? '';
        $title = preg_replace('/[\s-]+/u', '-', $title) ?? '';

        return trim($title, '-');
    }
}
