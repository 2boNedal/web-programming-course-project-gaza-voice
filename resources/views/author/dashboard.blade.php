@extends('layouts.author')

@section('page_title', 'Dashboard')

@section('content')
    <div class="row">
        @foreach ($stats as $stat)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="small-box text-bg-{{ $stat['color'] }}">
                    <div class="inner">
                        <h3>{{ number_format($stat['count']) }}</h3>
                        <p class="mb-0">{{ $stat['label'] }}</p>
                    </div>
                    <div class="small-box-icon">
                        <i class="{{ $stat['icon'] }}"></i>
                    </div>
                    <a href="{{ $stat['route'] }}" class="small-box-footer link-light link-underline-opacity-0">
                        Open {{ $stat['label'] }} <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
