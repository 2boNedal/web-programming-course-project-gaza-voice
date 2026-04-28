@extends('layouts.admin')

@section('page_title', 'Edit Author')

@section('content')
    @php
        $imageUrl = $author->profile_image
            ? asset('storage/' . ltrim($author->profile_image, '/'))
            : null;
    @endphp
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Author</h3>
                </div>
                <form action="{{ route('admin.authors.update', $author) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $author->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $author->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea name="bio" id="bio" rows="5" class="form-control @error('bio') is-invalid @enderror"
                                required>{{ old('bio', $author->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" id="is_active"
                                class="form-select @error('is_active') is-invalid @enderror" required>
                                <option value="1" @selected((string) old('is_active', (int) $author->is_active) === '1')>
                                    Active</option>
                                <option value="0" @selected((string) old('is_active', (int) $author->is_active) === '0')>
                                    Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Optional on update. Allowed: jpg, jpeg, png, webp.</small>
                        </div>

                        @if ($imageUrl)
                            <div class="mb-3">
                                <strong>Current Image</strong>
                                <div class="mt-2">
                                    <img src="{{ $imageUrl }}" alt="Author Image" class="img-fluid rounded border"
                                        style="max-width: 220px;">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.authors.show', $author) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Author</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
