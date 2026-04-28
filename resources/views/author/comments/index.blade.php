@extends('layouts.author')

@section('page_title', 'Comments')

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
                    <h3 class="card-title">Comments on My Articles</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Article</th>
                                    <th>Guest</th>
                                    <th>Email</th>
                                    <th>Content</th>
                                    <th>Created At</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->id }}</td>
                                        <td>{{ $comment->article?->title ?? '-' }}</td>
                                        <td>{{ $comment->guest_name }}</td>
                                        <td>{{ $comment->guest_email }}</td>
                                        <td style="min-width: 280px;">{{ $comment->content }}</td>
                                        <td>{{ $comment->created_at?->format('Y-m-d H:i') }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('author.comments.destroy', $comment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">No comments found.</td>
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
