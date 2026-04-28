@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
    <div class="row">
        @foreach ($stats as $stat)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="small-box text-bg-{{ $stat['color'] }}">
                    <div class="inner">
                        <h3>{{ number_format($stat['count']) }}</h3>
                        <p class="mb-1">{{ $stat['label'] }}</p>
                        @if (!empty($stat['meta']))
                            <small>{{ $stat['meta'] }}</small>
                        @endif
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
