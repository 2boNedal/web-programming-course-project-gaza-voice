@extends('layouts.admin')

@section('page_title', 'Tags')

@section('content')
    <div class="row">
        <div class="col-lg-4">
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
                    <h3 class="card-title">Create Tag</h3>
                </div>
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-0">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Tag</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tags List</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Articles</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tags as $tag)
                                    <tr>
                                        <td>{{ $tag->id }}</td>
                                        <td>{{ $tag->name }}</td>
                                        <td>{{ $tag->articles()->withTrashed()->count() }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-primary btn-sm" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#edit-tag-{{ $tag->id }}"
                                                aria-expanded="false"
                                                aria-controls="edit-tag-{{ $tag->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="edit-tag-{{ $tag->id }}">
                                        <td colspan="4" class="bg-body-tertiary">
                                            <form action="{{ route('admin.tags.update', $tag) }}" method="POST"
                                                class="row g-3 align-items-end">
                                                @csrf
                                                @method('PATCH')
                                                <div class="col-md-10">
                                                    <label for="edit-name-{{ $tag->id }}"
                                                        class="form-label">Name</label>
                                                    <input type="text" name="name"
                                                        id="edit-name-{{ $tag->id }}"
                                                        class="form-control"
                                                        value="{{ old('name', $tag->name) }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success w-100">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No tags found.</td>
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

