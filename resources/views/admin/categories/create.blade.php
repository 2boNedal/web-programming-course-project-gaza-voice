@extends('layouts.admin')

@section('page_title', 'Create Category')

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Create Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @include('admin.categories._form', ['submitLabel' => 'Create'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
