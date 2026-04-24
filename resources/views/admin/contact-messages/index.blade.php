@extends('layouts.admin')

@section('page_title', 'Contact Inbox')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Contact Inbox</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th style="width: 70px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th style="width: 260px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($messages as $message)
                                <tr>
                                    <td>{{ $message->id }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->subject }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($message->message, 100) }}</td>
                                    <td>
                                        @if ($message->is_read)
                                            <span class="badge text-bg-success">Read</span>
                                        @else
                                            <span class="badge text-bg-secondary">Unread</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($message->is_read)
                                            <form action="{{ route('admin.contact-messages.unread', $message->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-warning btn-sm">Mark Unread</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.contact-messages.read', $message->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">Mark Read</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this message permanently?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No messages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
