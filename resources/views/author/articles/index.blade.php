@extends('layouts.author')
@section('content')
    <h1>قائمة مقالاتي</h1>
    <a href="{{ route('author.articles.create') }}" class="btn btn-primary">إضافة مقال جديد</a>
@endsection
