@extends('layouts.admin')

@section('page_title', 'Breaking News')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Banner</h3>
                </div>
                <form action="{{ route('admin.banners.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-0">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Banner</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Banners List</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Created At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>{{ $banner->title }}</td>
                                        <td>{{ $banner->created_at?->format('Y-m-d H:i') }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-primary btn-sm" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#edit-banner-{{ $banner->id }}"
                                                aria-expanded="false"
                                                aria-controls="edit-banner-{{ $banner->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.banners.destroy', $banner) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="edit-banner-{{ $banner->id }}">
                                        <td colspan="4" class="bg-body-tertiary">
                                            <form action="{{ route('admin.banners.update', $banner) }}"
                                                method="POST" class="row g-3 align-items-end">
                                                @csrf
                                                @method('PATCH')
                                                <div class="col-md-10">
                                                    <label for="edit-title-{{ $banner->id }}"
                                                        class="form-label">Title</label>
                                                    <input type="text" name="title"
                                                        id="edit-title-{{ $banner->id }}"
                                                        class="form-control"
                                                        value="{{ old('title', $banner->title) }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success w-100">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No banners found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

