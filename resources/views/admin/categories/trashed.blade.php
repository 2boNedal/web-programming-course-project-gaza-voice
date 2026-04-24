@extends('layouts.admin')

@section('page_title', 'Trashed Categories')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->has('delete'))
                <div class="alert alert-danger">{{ $errors->first('delete') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Trashed Categories</h3>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">Back to Categories</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th style="width: 70px">#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th style="width: 260px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>

                                        <form action="{{ route('admin.categories.force-delete', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Permanently delete this category?')">Force Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No trashed categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
