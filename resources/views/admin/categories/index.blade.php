@extends('layouts.admin')

@section('page_title', 'Categories')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Category</h3>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST" id="create-category-form">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" id="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Auto-generated from name if left empty. You can edit it.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Categories List</h3>
                    <a href="{{ route('admin.categories.trashed') }}" class="btn btn-secondary btn-sm">
                        Trashed Categories
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Articles</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->articles()->withTrashed()->count() }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-primary btn-sm" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#edit-category-{{ $category->id }}"
                                                aria-expanded="false"
                                                aria-controls="edit-category-{{ $category->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Trash</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="edit-category-{{ $category->id }}">
                                        <td colspan="5" class="bg-body-tertiary">
                                            <form action="{{ route('admin.categories.update', $category) }}"
                                                method="POST"
                                                class="row g-3 align-items-end category-edit-form">
                                                @csrf
                                                @method('PATCH')
                                                <div class="col-md-5">
                                                    <label for="edit-name-{{ $category->id }}"
                                                        class="form-label">Name</label>
                                                    <input type="text" name="name"
                                                        id="edit-name-{{ $category->id }}"
                                                        class="form-control"
                                                        value="{{ old('name', $category->name) }}" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="edit-slug-{{ $category->id }}"
                                                        class="form-label">Slug</label>
                                                    <input type="text" name="slug"
                                                        id="edit-slug-{{ $category->id }}"
                                                        class="form-control"
                                                        value="{{ old('slug', $category->slug) }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success w-100">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slugify = (value) => value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\\s-]/g, '')
                .replace(/\\s+/g, '-')
                .replace(/-+/g, '-');

            const bindSlugAutoFill = (form, nameSelector, slugSelector) => {
                const nameInput = form.querySelector(nameSelector);
                const slugInput = form.querySelector(slugSelector);

                if (!nameInput || !slugInput) {
                    return;
                }

                let slugTouched = slugInput.value.trim() !== '';

                slugInput.addEventListener('input', function() {
                    slugTouched = this.value.trim() !== '';
                });

                nameInput.addEventListener('input', function() {
                    if (!slugTouched) {
                        slugInput.value = slugify(this.value);
                    }
                });
            };

            const createForm = document.getElementById('create-category-form');
            if (createForm) {
                bindSlugAutoFill(createForm, '#name', '#slug');
            }

            document.querySelectorAll('.category-edit-form').forEach(function(form) {
                bindSlugAutoFill(form, 'input[name="name"]', 'input[name="slug"]');
            });
        });
    </script>
@endsection

