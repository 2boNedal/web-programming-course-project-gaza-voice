@extends('layouts.admin')

@section('page_title', 'Create Tag')

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Create Tag</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tags.store') }}" method="POST">
                        @include('admin.tags._form', ['submitLabel' => 'Create'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
