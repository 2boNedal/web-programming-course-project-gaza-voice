@extends('layouts.author')

@section('page_title', 'My Profile')

@section('content')
    @php
        $imageUrl = $author->profile_image
            ? asset('storage/' . ltrim($author->profile_image, '/'))
            : null;
    @endphp

    <style>
        .author-profile-image-panel {
            max-width: 260px;
        }

        .author-profile-image-frame {
            width: 100%;
            aspect-ratio: 4 / 5;
            border: 1px solid var(--bs-border-color);
            border-radius: 0.75rem;
            background: var(--bs-secondary-bg);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .author-profile-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .author-profile-image-fallback {
            width: 100%;
            aspect-ratio: 4 / 5;
            border: 1px dashed var(--bs-border-color);
            border-radius: 0.75rem;
            background: var(--bs-secondary-bg);
            color: var(--bs-secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1rem;
        }
    </style>

    <div class="row">
        <div class="col-lg-8">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Update Profile</h3>
                </div>
                <form action="{{ route('author.profile.update') }}" method="POST" enctype="multipart/form-data">
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
                            <textarea name="bio" id="bio" rows="5" class="form-control @error('bio') is-invalid @enderror" required>{{ old('bio', $author->bio) }}</textarea>
                            @error('bio')
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
                            <small class="text-muted">Allowed: jpg, jpeg, png, webp.</small>
                        </div>

                        @if ($imageUrl)
                            <div class="mb-3">
                                <strong>Current Image</strong>
                                <div class="mt-3 author-profile-image-panel">
                                    <div class="author-profile-image-frame">
                                        <img src="{{ $imageUrl }}" alt="Author Image">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <strong>Current Image</strong>
                                <div class="mt-3 author-profile-image-panel">
                                    <div class="author-profile-image-fallback">
                                        <span>No image available.</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Profile</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                </div>
                <form action="{{ route('author.profile.password') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
