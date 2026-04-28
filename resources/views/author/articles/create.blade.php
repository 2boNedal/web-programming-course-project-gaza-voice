@extends('layouts.author')

@section('page_title', 'Create Draft')

@section('content')
    <form action="{{ route('author.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('author.articles._form', ['submitLabel' => 'Create Draft'])
    </form>
@endsection
