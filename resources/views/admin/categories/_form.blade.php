@csrf

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input
        type="text"
        id="name"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $category->name ?? '') }}"
        required
        maxlength="120"
    >
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="slug" class="form-label">Slug</label>
    <input
        type="text"
        id="slug"
        name="slug"
        class="form-control @error('slug') is-invalid @enderror"
        value="{{ old('slug', $category->slug ?? '') }}"
        maxlength="160"
        required
    >
    @error('slug')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Slug is auto-generated from the name when left empty, and you can edit it.</div>
</div>

<button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>

<script>
    (function () {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        if (!nameInput || !slugInput) {
            return;
        }

        let slugTouched = slugInput.value.trim() !== '';

        slugInput.addEventListener('input', function () {
            slugTouched = true;
        });

        nameInput.addEventListener('input', function () {
            if (slugTouched) {
                return;
            }

            const generated = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');

            slugInput.value = generated;
        });
    })();
</script>
