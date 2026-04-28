@php
    $bannerItems = ($banners ?? collect())
        ->filter(fn ($banner) => filled($banner->title))
        ->map(fn ($banner) => [
            'title' => $banner->title,
            'created_at' => optional($banner->created_at)?->toIso8601String(),
        ])
        ->values();

    $initialBanner = $bannerItems->first();

    $coverImageUrl = static function ($article): string {
        $path = ltrim((string) ($article?->cover_image ?? ''), '/');

        return $path !== '' ? asset('storage/' . $path) : asset('/front/img/top-news-1.jpg');
    };

    $authorImageUrl = static function ($author): string {
        $path = ltrim((string) ($author?->profile_image ?? ''), '/');

        if ($path !== '') {
            return asset('storage/' . $path);
        }

        $initial = urlencode(mb_substr((string) ($author?->name ?? 'A'), 0, 1));

        return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='96' height='96' viewBox='0 0 96 96'%3E%3Crect width='96' height='96' rx='48' fill='%23e9ecef'/%3E%3Ctext x='48' y='58' text-anchor='middle' font-size='34' fill='%236c757d' font-family='Arial,sans-serif'%3E{$initial}%3C/text%3E%3C/svg%3E";
    };

    $articleParagraphs = collect(preg_split('/\R{2,}/u', trim((string) $article->body)) ?: [])
        ->map(fn ($paragraph) => trim($paragraph))
        ->filter();
@endphp
<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>{{ $article->title }} - News 24</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="{{ $article->title }}" name="keywords" />
    <meta content="{{ \Illuminate\Support\Str::limit(strip_tags($article->body), 150) }}" name="description" />

    <link href="/front/img/favicon.ico" rel="icon" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="/front/lib/slick/slick.css" rel="stylesheet" />
    <link href="/front/lib/slick/slick-theme.css" rel="stylesheet" />
    <link href="/front/css/style.css" rel="stylesheet" />
</head>

<body class="public-rtl">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="logo">
                            <a href="/">
                                <img src="/front/img/logo.png" alt="Logo" />
                            </a>
                        </div>
                        <div class="social ml-3">
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-facebook"></i></a>
                            <a href=""><i class="fab fa-linkedin"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                            <a href=""><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 text-right">
                    <a href="/login" class="login-btn">Login</a>
                </div>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="container">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand d-none d-md-block">
                    <img src="/front/img/logo.png" alt="Logo" class="navbar-logo" />
                </a>
                <a href="#" class="navbar-brand d-md-none">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="/" class="nav-item nav-link">الرئيسية</a>
                        @foreach (($navbarCategories ?? collect()) as $navbarCategory)
                            <a href="{{ route('categories.show', $navbarCategory->slug) }}" class="nav-item nav-link">
                                {{ $navbarCategory->name }}
                            </a>
                        @endforeach
                        <a href="/contact" class="nav-item nav-link">اتصل بنا</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    @if ($initialBanner)
        <div class="latest-news-strip breaking-news-strip">
            <div class="container-fluid">
                <div class="latest-news-container">
                    <div class="latest-news-label">
                        <span class="label-icon"><i class="fas fa-circle"></i></span>
                        <span class="label-text">عاجل</span>
                    </div>

                    <div class="latest-news-ticker">
                        <div class="ticker-content">
                            <span class="ticker-headline" id="breakingNewsTicker" data-source="banners">
                                {{ $initialBanner['title'] }}
                            </span>
                        </div>
                        <span class="ticker-meta">
                            <i class="far fa-clock"></i>
                            <span id="breakingNewsTickerTime"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="single-news py-5">
        <div class="container">
            <div class="sn-container mx-auto" style="max-width: 900px;">
                <div class="sn-content">
                    <h1 class="sn-title d-block mb-3">{{ $article->title }}</h1>

                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <span class="sn-date d-inline-block">
                            <i class="far fa-clock"></i>
                            {{ $article->published_at?->format('Y-m-d H:i') ?? '-' }}
                        </span>

                        <div id="article-author" class="d-flex align-items-center" style="gap: 14px;">
                            <a href="{{ $article->author ? route('authors.show', $article->author->id) : '#article-author' }}"
                                class="d-flex align-items-center text-decoration-none text-muted" style="gap: 10px;">
                                <img src="{{ $authorImageUrl($article->author) }}"
                                    alt="{{ $article->author?->name ?? 'Author' }}"
                                    style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 1px solid rgba(0,0,0,.08);" />
                                <span>{{ $article->author?->name ?? 'Author' }}</span>
                            </a>
                            <span class="text-muted d-inline-flex align-items-center" style="gap: 6px;">
                                <i class="far fa-eye" aria-hidden="true"></i>
                                <span>{{ number_format((int) ($article->views_count ?? 0)) }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="sn-img mb-4">
                        <img src="{{ $coverImageUrl($article) }}" alt="{{ $article->title }}" class="img-fluid w-100" />
                    </div>

                    <div class="article-body mb-5" style="line-height: 1.95; font-size: 1.05rem;">
                        @forelse ($articleParagraphs as $paragraph)
                            <p class="mb-4">{!! nl2br(e($paragraph)) !!}</p>
                        @empty
                            <p class="mb-0">{{ $article->body }}</p>
                        @endforelse
                    </div>

                    <div id="comments" class="mb-4">
                        <h3 class="mb-4">Comments ({{ $comments->count() }})</h3>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                Please correct the comment form errors and try again.
                            </div>
                        @endif

                        @forelse ($comments as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong>{{ $comment->guest_name }}</strong>
                                            <div class="text-muted small">{{ $comment->guest_email }}</div>
                                        </div>
                                        <span class="text-muted small">
                                            {{ $comment->created_at?->format('Y-m-d H:i') }}
                                        </span>
                                    </div>
                                    <p class="mb-0">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light border">
                                No comments yet.
                            </div>
                        @endforelse
                    </div>

                    <div class="card mb-5">
                        <div class="card-header">
                            <h4 class="mb-0">Leave a Comment</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="guest_name">Name</label>
                                        <input type="text" id="guest_name" name="guest_name"
                                            class="form-control @error('guest_name') is-invalid @enderror"
                                            value="{{ old('guest_name') }}" required>
                                        @error('guest_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="guest_email">Email</label>
                                        <input type="email" id="guest_email" name="guest_email"
                                            class="form-control @error('guest_email') is-invalid @enderror"
                                            value="{{ old('guest_email') }}" required>
                                        @error('guest_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content">Comment</label>
                                    <textarea id="content" name="content" rows="5"
                                        class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @error('article_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </form>
                        </div>
                    </div>

                    @if ($relatedArticles->isNotEmpty())
                        <div class="mb-4">
                            <h3 class="mb-4">Related Articles</h3>
                            <div class="row">
                                @foreach ($relatedArticles as $relatedArticle)
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="news-card h-100">
                                            <img src="{{ $coverImageUrl($relatedArticle) }}"
                                                alt="{{ $relatedArticle->title }}" />
                                            <div class="news-card-body">
                                                @if (filled($relatedArticle->related_badge_label))
                                                    <span class="news-card-category">
                                                        {{ $relatedArticle->related_badge_label }}
                                                    </span>
                                                @endif
                                                <a class="news-card-title"
                                                    href="{{ route('articles.show', ['slug' => $relatedArticle->slug]) }}">
                                                    {{ $relatedArticle->title }}
                                                </a>
                                                <p class="news-card-text">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags((string) $relatedArticle->body), 110) }}
                                                </p>
                                                <span class="news-card-meta">
                                                    <i class="far fa-clock"></i>
                                                    {{ $relatedArticle->published_at?->format('Y-m-d H:i') ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="footer-logo">
                        <img src="/front/img/logo.png" alt="Logo" />
                    </div>
                </div>
                <div class="col-md-6 copyright">
                    <p>© 2026 جميع الحقوق محفوظة لوكالة صوت غزة الإخبارية</p>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/front/lib/easing/easing.min.js"></script>
    <script src="/front/lib/slick/slick.min.js"></script>
    <script src="/front/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const banners = @json($bannerItems);
            const ticker = document.getElementById('breakingNewsTicker');
            const tickerTime = document.getElementById('breakingNewsTickerTime');

            const formatBannerTime = function(dateString) {
                if (!dateString) {
                    return '';
                }

                const date = new Date(dateString);

                if (Number.isNaN(date.getTime())) {
                    return '';
                }

                return String(date.getHours()).padStart(2, '0') + ':' + String(date.getMinutes()).padStart(2, '0');
            };

            if (!ticker || !tickerTime || !Array.isArray(banners) || banners.length === 0) {
                return;
            }

            let currentIndex = 0;

            const renderBanner = function(index) {
                const banner = banners[index] || {};
                ticker.textContent = banner.title || '';
                tickerTime.textContent = formatBannerTime(banner.created_at);
            };

            renderBanner(currentIndex);

            if (banners.length > 1) {
                setInterval(function() {
                    currentIndex = (currentIndex + 1) % banners.length;
                    renderBanner(currentIndex);
                }, 4000);
            }
        });
    </script>
</body>

</html>
