@extends('layouts.front')

@section('content')
<!-- Include CSS from home if needed, but assuming style.css covers it -->
<link href="/front/css/style.css" rel="stylesheet" />
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <h1>{{ $article->title }}</h1>
            <p class="text-muted">{{ $article->published_at ? $article->published_at->format('d-M-Y') : '' }}</p>
            @if($article->cover_image)
                <img src="{{ $article->cover_image }}" class="img-fluid mb-4" alt="{{ $article->title }}">
            @endif
            <div class="article-body">
                {!! $article->body !!}
            </div>
        </div>
    </div>

    <!-- Related Articles Section -->
    <div class="related-articles mt-5">
        <div class="section-header mb-4">
            <h2 style="border-right: 5px solid #FF6F61; padding-right: 15px;">مقالات ذات صلة</h2>
        </div>
        <div class="row">
            @foreach($related as $rel)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="news-card" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff; height: 100%;">
                    @if($rel->cover_image)
                        <img src="{{ $rel->cover_image }}" alt="{{ $rel->title }}" style="width: 100%; height: 180px; object-fit: cover;" />
                    @endif
                    <div class="news-card-body" style="padding: 15px;">
                        <span class="news-card-category" style="background: #FF6F61; color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-bottom: 10px; display: inline-block;">
                            {{ $rel->related_by == 'category' ? $rel->category->name : 'وسم' }}
                        </span>
                        <h4 style="font-size: 16px; margin-bottom: 10px;">
                            <a class="news-card-title" href="{{ route('front.articles.show', $rel->slug) }}" style="color: #333; text-decoration: none;">{{ $rel->title }}</a>
                        </h4>
                        <p class="news-card-text" style="font-size: 14px; color: #666;">
                            {{ \Illuminate\Support\Str::limit(strip_tags($rel->body), 60) }}
                        </p>
                        <span class="news-card-meta" style="font-size: 12px; color: #999;"><i class="far fa-clock"></i> {{ $rel->published_at ? $rel->published_at->format('d-M-Y') : '' }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .news-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
</style>
@endsection
