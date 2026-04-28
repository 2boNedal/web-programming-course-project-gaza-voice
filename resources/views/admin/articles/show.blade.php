@extends('layouts.admin')

@section('page_title', 'View Article')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">{{ $article->title }}</h3>
            <div>
                @if ($article->status === 'pending_review')
                    <form action="{{ route('admin.articles.publish', $article) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-success">Publish</button>
                    </form>

                    <form action="{{ route('admin.articles.needs-revision', $article) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-warning">Needs Revision</button>
                    </form>
                @elseif ($article->status === 'published')
                    <form action="{{ route('admin.articles.archive', $article) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Archive</button>
                    </form>
                @elseif ($article->status === 'draft' && $article->draft_origin === 'admin' && filled($article->restore_to_status))
                    <form action="{{ route('admin.articles.restore-admin-draft', $article) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                    </form>
                @endif

                @if ($article->status === 'draft')
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Trash</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <strong>Author:</strong>
                    <div>{{ $article->author?->name ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <strong>Category:</strong>
                    <div>{{ $article->category?->name ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <strong>Status:</strong>
                    <div>{{ $article->status }}</div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <strong>Draft Origin:</strong>
                    <div>{{ $article->draft_origin }}</div>
                </div>
                <div class="col-md-4">
                    <strong>Submitted At:</strong>
                    <div>{{ $article->submitted_at?->format('Y-m-d H:i') ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <strong>Published At:</strong>
                    <div>{{ $article->published_at?->format('Y-m-d H:i') ?? '-' }}</div>
                </div>
            </div>

            <div class="mb-4">
                <strong>Slug:</strong>
                <div>{{ $article->slug }}</div>
            </div>

            <div class="mb-4">
                <strong>Tags:</strong>
                <div>{{ $article->tags->pluck('name')->join(', ') }}</div>
            </div>

            <div class="mb-4">
                <strong>Cover Image:</strong>
                <div class="mt-2">
                    <img src="{{ $article->cover_image ? asset('storage/' . ltrim($article->cover_image, '/')) : asset('front/img/top-news-1.jpg') }}"
                        alt="{{ $article->title }}" style="width: 260px; height: 180px; object-fit: cover;"
                        class="rounded border">
                </div>
            </div>

            <div>
                <strong>Body:</strong>
                <div class="mt-2" style="line-height: 1.9;">
                    {!! nl2br(e($article->body)) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
