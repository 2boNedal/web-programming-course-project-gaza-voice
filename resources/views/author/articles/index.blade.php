@extends('layouts.author')

@section('page_title', 'Articles')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('author.articles.create') }}" class="btn btn-primary">Create Draft</a>
    </div>

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
                                <th>Slug</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Status</th>
                                <th>Draft Origin</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->slug }}</td>
                                    <td>{{ $article->category?->name ?? '-' }}</td>
                                    <td>{{ $article->tags->pluck('name')->join(', ') }}</td>
                                    <td>{{ $article->status }}</td>
                                    <td>{{ $article->draft_origin }}</td>
                                    <td class="text-end">
                                        @if (in_array($article->status, ['draft', 'needs_revision'], true) && $article->draft_origin === 'author')
                                            <a href="{{ route('author.articles.edit', $article) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            @if ($article->status === 'needs_revision')
                                                <form action="{{ route('author.articles.save-draft', $article) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        Save as Draft
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('author.articles.submit-review', $article) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    Send for Review
                                                </button>
                                            </form>

                                            @if ($article->status === 'draft')
                                                <form action="{{ route('author.articles.destroy', $article) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-muted small">Read only</span>
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
