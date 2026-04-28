@extends('layouts.admin')

@section('page_title', 'Articles')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $sections = [
            'Published' => $publishedArticles,
            'Pending Review' => $pendingReviewArticles,
            'Needs Revision' => $needsRevisionArticles,
            'Draft' => $draftArticles,
        ];
    @endphp

    @foreach ($sections as $label => $items)
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title mb-0">{{ $label }}</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Status</th>
                                <th>Draft Origin</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->author?->name ?? '-' }}</td>
                                    <td>{{ $article->category?->name ?? '-' }}</td>
                                    <td>{{ $article->tags->pluck('name')->join(', ') }}</td>
                                    <td>{{ $article->status }}</td>
                                    <td>{{ $article->draft_origin }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.articles.show', $article) }}"
                                            class="btn btn-sm btn-outline-primary">View</a>

                                        @if ($article->status === 'pending_review')
                                            <form action="{{ route('admin.articles.publish', $article) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-success">Publish</button>
                                            </form>

                                            <form action="{{ route('admin.articles.needs-revision', $article) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                                    Needs Revision
                                                </button>
                                            </form>
                                        @elseif ($article->status === 'published')
                                            <form action="{{ route('admin.articles.archive', $article) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Archive</button>
                                            </form>
                                        @elseif ($article->status === 'draft' && $article->draft_origin === 'admin' && filled($article->restore_to_status))
                                            <form action="{{ route('admin.articles.restore-admin-draft', $article) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                                            </form>
                                        @endif

                                        @if ($article->status === 'draft')
                                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Trash</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No articles in this state.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@endsection
