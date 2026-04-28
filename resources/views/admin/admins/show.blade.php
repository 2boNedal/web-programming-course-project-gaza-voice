@extends('layouts.admin')

@section('page_title', 'View Admin')

@section('content')
    @php
        $avatarUrl = $admin->avatar
            ? asset('storage/' . ltrim($admin->avatar, '/'))
            : null;
    @endphp

    <style>
        .admin-image-panel {
            max-width: 260px;
        }

        .admin-image-frame {
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

        .admin-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .admin-image-fallback {
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

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Admin #{{ $admin->id }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <strong>Avatar</strong>
                            <div class="mt-3 admin-image-panel">
                                @if ($avatarUrl)
                                    <div class="admin-image-frame">
                                        <img src="{{ $avatarUrl }}" alt="Admin Avatar">
                                    </div>
                                @else
                                    <div class="admin-image-fallback">
                                        <span>No avatar uploaded.</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <p><strong>Name:</strong> {{ $admin->name }}</p>
                            <p><strong>Email:</strong> {{ $admin->email }}</p>
                            <p>
                                <strong>Status:</strong>
                                @if ($admin->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                            <p><strong>Last Login:</strong> {{ $admin->last_login_at?->format('Y-m-d H:i') ?? '-' }}</p>
                            <p><strong>Created At:</strong> {{ $admin->created_at?->format('Y-m-d H:i') }}</p>
                            <p class="mb-0"><strong>Updated At:</strong> {{ $admin->updated_at?->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Back to List</a>
                    <form action="{{ route('admin.admins.toggle-active', $admin) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $admin->is_active ? 'btn-warning' : 'btn-success' }}">
                            {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
