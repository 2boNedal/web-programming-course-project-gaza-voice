<?php

namespace App\Http\Requests\Author;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
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
        /** @var Article|null $article */
        $article = $this->route('article');

        $coverImageRules = ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'];

        if (!$article?->cover_image) {
            $coverImageRules[0] = 'required';
        }

        return [
            'title' => ['required', 'string', 'max:220'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('articles', 'slug')->ignore($article?->id),
            ],
            'body' => ['required', 'string'],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
            ],
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['integer', 'distinct', 'exists:tags,id'],
            'cover_image' => $coverImageRules,
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
