@csrf

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input
        type="text"
        id="name"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $tag->name ?? '') }}"
        required
        maxlength="80"
    >
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
<a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Cancel</a>
