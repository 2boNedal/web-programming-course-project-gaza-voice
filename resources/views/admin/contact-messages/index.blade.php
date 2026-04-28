@extends('layouts.admin')

@section('page_title', 'Contact Messages')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inbox</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Submitted At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contactMessages as $contactMessage)
                                    <tr>
                                        <td>{{ $contactMessage->id }}</td>
                                        <td>{{ $contactMessage->name }}</td>
                                        <td>{{ $contactMessage->email }}</td>
                                        <td>{{ $contactMessage->subject }}</td>
                                        <td style="min-width: 280px;">{{ $contactMessage->message }}</td>
                                        <td>
                                            @if ($contactMessage->is_read)
                                                <span class="badge text-bg-success">Read</span>
                                            @else
                                                <span class="badge text-bg-warning">Unread</span>
                                            @endif
                                        </td>
                                        <td>{{ $contactMessage->created_at?->format('Y-m-d H:i') }}</td>
                                        <td class="text-end">
                                            @if ($contactMessage->is_read)
                                                <form action="{{ route('admin.contact-messages.unread', $contactMessage) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        Mark Unread
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.contact-messages.read', $contactMessage) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        Mark Read
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No contact messages found.</td>
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
