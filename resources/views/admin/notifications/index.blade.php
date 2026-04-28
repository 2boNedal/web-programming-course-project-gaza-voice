@extends('layouts.admin')

@section('page_title', 'Notifications')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Admin Notifications</h3>

                    @if ($unreadCount > 0)
                        <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-primary">Mark All as Read</button>
                        </form>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Created</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($notifications as $notification)
                                    <tr>
                                        <td>
                                            @if (is_null($notification->read_at))
                                                <span class="badge text-bg-warning">Unread</span>
                                            @else
                                                <span class="badge text-bg-success">Read</span>
                                            @endif
                                        </td>
                                        <td>{{ $notification->data['title'] ?? 'Notification' }}</td>
                                        <td>
                                            <div>{{ $notification->data['message'] ?? '-' }}</div>
                                            @if (!empty($notification->data['details']))
                                                <small class="text-muted">{{ $notification->data['details'] }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $notification->created_at?->format('Y-m-d H:i') }}</td>
                                        <td class="text-end">
                                            @if (is_null($notification->read_at))
                                                <form action="{{ route('admin.notifications.read', $notification->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        Mark as Read
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">Already read</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No notifications found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($notifications->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{ $notifications->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
