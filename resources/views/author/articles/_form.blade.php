@php
    $selectedTagIds = collect(old('tags', isset($article) ? $article->tags->pluck('id')->all() : []))
        ->map(fn ($value) => (int) $value)
        ->all();

    $generateSlugFromTitle = function (string $title): string {
        $title = mb_strtolower(trim($title), 'UTF-8');
        $title = preg_replace('/[^\p{Arabic}\p{L}\p{N}\s-]+/u', '', $title) ?? '';
        $title = preg_replace('/[\s-]+/u', '-', $title) ?? '';

        return trim($title, '-');
    };

    $oldSlug = old('slug');
    $oldTitle = old('title', $article->title ?? '');

    $slugFieldValue = filled($oldSlug)
        ? $oldSlug
        : (filled($oldTitle)
            ? $generateSlugFromTitle($oldTitle)
            : ($article->slug ?? ''));
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        Please correct the form errors and try again.
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $article->title ?? '') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                value="{{ $slugFieldValue }}">
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">If left empty, it will be generated from the title. If it is duplicated, edit it manually.</small>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected((int) old('category_id', $article->category_id ?? 0) === $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <div class="border rounded p-3 @error('tags') border-danger @enderror">
                <div class="row g-2">
                    @foreach ($tags as $tag)
                        <div class="col-md-4 col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]"
                                    id="tag_{{ $tag->id }}" value="{{ $tag->id }}"
                                    @checked(in_array($tag->id, $selectedTagIds, true))>
                                <label class="form-check-label" for="tag_{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @error('tags')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            @error('tags.*')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="text-muted">Select one or more tags.</small>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            <input type="file" id="cover_image" name="cover_image"
                class="form-control @error('cover_image') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp"
                {{ isset($article) && $article->cover_image ? '' : 'required' }}>
            @error('cover_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if (!empty($article?->cover_image))
                <div class="mt-3">
                    <img src="{{ asset('storage/' . ltrim($article->cover_image, '/')) }}" alt="{{ $article->title }}"
                        style="width: 180px; height: 120px; object-fit: cover;" class="rounded border">
                </div>
            @endif
        </div>

        <div class="mb-0">
            <label for="body" class="form-label">Body</label>
            <textarea id="body" name="body" rows="12" class="form-control @error('body') is-invalid @enderror" required>{{ old('body', $article->body ?? '') }}</textarea>
            @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        if (!titleInput || !slugInput) {
            return;
        }

        const slugify = function (value) {
            return value
                .toString()
                .trim()
                .toLowerCase()
                .replace(/[^\p{Arabic}\p{L}\p{N}\s-]+/gu, '')
                .replace(/[\s-]+/gu, '-')
                .replace(/^-+|-+$/g, '');
        };

        let slugEditedManually = slugInput.value.trim() !== '';

        slugInput.addEventListener('input', function () {
            slugEditedManually = slugInput.value.trim() !== '';
        });

        titleInput.addEventListener('input', function () {
            if (slugEditedManually) {
                return;
            }

            slugInput.value = slugify(titleInput.value);
        });
    });
</script>
