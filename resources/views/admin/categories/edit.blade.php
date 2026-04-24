@extends('layouts.admin')

@section('page_title', 'Edit Category')

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Edit Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @method('PUT')
                        @include('admin.categories._form', ['submitLabel' => 'Update', 'category' => $category])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
