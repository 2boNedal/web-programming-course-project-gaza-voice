@extends('layouts.admin')

@section('page_title', 'View Author')

@section('content')
    @php
        $imageUrl = $author->profile_image
            ? asset('storage/' . ltrim($author->profile_image, '/'))
            : null;
    @endphp

    <style>
        .author-image-panel {
            max-width: 260px;
        }

        .author-image-frame {
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

        .author-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .author-image-fallback {
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
                    <h3 class="card-title">Author #{{ $author->id }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <strong>Profile Image</strong>
                            <div class="mt-3 author-image-panel">
                                @if ($imageUrl)
                                    <div class="author-image-frame">
                                        <img src="{{ $imageUrl }}" alt="Author Image">
                                    </div>
                                @else
                                    <div class="author-image-fallback">
                                        <span>No image available.</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <p><strong>Name:</strong> {{ $author->name }}</p>
                            <p><strong>Email:</strong> {{ $author->email }}</p>
                            <p><strong>Bio:</strong> {{ $author->bio }}</p>
                            <p>
                                <strong>Status:</strong>
                                @if ($author->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                            <p><strong>Created By Admin ID:</strong> {{ $author->created_by_admin_id ?? '-' }}</p>
                            <p><strong>Last Login:</strong> {{ $author->last_login_at?->format('Y-m-d H:i') ?? '-' }}</p>
                            <p><strong>Created At:</strong> {{ $author->created_at?->format('Y-m-d H:i') }}</p>
                            <p class="mb-0"><strong>Updated At:</strong> {{ $author->updated_at?->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('admin.authors.edit', $author) }}" class="btn btn-primary">Edit</a>
                    </div>
                    <div>
                        <form action="{{ route('admin.authors.toggle-active', $author) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn {{ $author->is_active ? 'btn-warning' : 'btn-success' }}">
                                {{ $author->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Move To Trash</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reset Author Password</h3>
                </div>
                <form action="{{ route('admin.authors.password', $author) }}" method="POST">
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
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
