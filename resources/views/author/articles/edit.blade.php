@extends('layouts.author')

@section('page_title', 'Edit Article')

@section('content')
    <div class="alert alert-info">
        Only author drafts and needs revision articles created by the author can be edited.
    </div>

    <form action="{{ route('author.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @include('author.articles._form', ['submitLabel' => 'Update Article'])
    </form>
@endsection
