@extends('layouts.admin')

@section('page_title', 'Edit Tag')

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Edit Tag</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                        @method('PUT')
                        @include('admin.tags._form', ['submitLabel' => 'Update', 'tag' => $tag])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
