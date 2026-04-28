@extends('layouts.admin')

@section('page_title', 'Admins')

@section('content')
    @php
        $currentAdminId = Auth::guard('admin')->id();
    @endphp
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Admins List</h3>
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-sm">
                        Create Admin
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->id }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            @if ($admin->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $admin->created_at?->format('Y-m-d H:i') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.admins.show', $admin) }}"
                                                class="btn btn-info btn-sm">
                                                View
                                            </a>
                                            @if ($currentAdminId === $admin->id)
                                                <a href="{{ route('admin.admins.edit', $admin) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Edit
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.admins.toggle-active', $admin) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $admin->is_active ? 'btn-warning' : 'btn-success' }}">
                                                    {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No admins found.</td>
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
