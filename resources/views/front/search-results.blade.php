@php
    $articleImageUrl = static function ($article, string $fallback): string {
        $path = ltrim((string) ($article?->cover_image ?? ''), '/');

        return $path !== '' ? asset('storage/' . $path) : asset($fallback);
    };
    $articlePublishedAt = static function ($article): string {
        return optional($article?->published_at)->format('d-M-Y') ?: '';
    };
    $articleExcerpt = static function ($article, int $limit = 160): string {
        return \Illuminate\Support\Str::limit(trim(strip_tags((string) ($article?->body ?? ''))), $limit);
    };
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <title>نتائج البحث - News 24</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Tag search results" name="keywords">
    <meta content="Search results for selected tags" name="description">

    <link href="/front/img/favicon.ico" rel="icon">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="/front/lib/slick/slick.css" rel="stylesheet">
    <link href="/front/lib/slick/slick-theme.css" rel="stylesheet">

    <link href="/front/css/style.css" rel="stylesheet">
</head>

<body class="public-rtl">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="logo">
                            <a href="/">
                                <img src="/front/img/logo.png" alt="Logo">
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
                    <img src="/front/img/logo.png" alt="Logo" class="navbar-logo">
                </a>
                <a href="#" class="navbar-brand d-md-none">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="/" class="nav-item nav-link">الرئيسية</a>
                        @foreach ($navbarCategories as $navbarCategory)
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

    <div class="nav-search-panel" id="navSearchPanel">
        <div class="container">
            <div class="search-panel-inner">
                <div class="search-panel-header">
                    <div class="search-panel-title"><i class="fas fa-search"></i> بحث بالوسوم</div>
                    <button type="button" class="search-panel-close" id="searchPanelClose"><i class="fas fa-times"></i></button>
                </div>
                <div class="search-panel-body">
                    <div class="search-input-group">
                        <div class="input-with-icon">
                            <input class="search-tag-input" id="searchTagInput" type="text" placeholder="اكتب لاقتراح الوسوم..." autocomplete="off">
                            <button type="button" class="search-input-icon" id="searchInputIcon"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="tag-suggestions" id="tagSuggestions"></div>
                    </div>
                    <div class="selected-tags" id="selectedSearchTags"></div>
                    <div class="available-tags">
                        <div class="available-tags-label">الوسوم المتاحة</div>
                        <div class="tag-list">
                            @foreach ($availableTags as $tag)
                                <button type="button" class="tag-chip" data-tag="{{ $tag->name }}" data-tag-id="{{ $tag->id }}">
                                    {{ $tag->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="search-results-hero">
        <div class="container-fluid">
            <div class="category-hero-content">
                <h1 class="category-title">نتائج البحث</h1>
                <p class="category-subtitle">عرض الأخبار المرتبطة بالوسوم التي اخترتها.</p>
            </div>
        </div>
    </div>

    <div class="search-results-section">
        <div class="container-fluid">
            <div class="search-results-meta">
                <div class="search-results-label">الوسوم المحددة</div>
                <div class="selected-filter-tags" id="searchResultsActiveTags">
                    @foreach ($selectedTags as $tag)
                        <span class="tag-chip selected-tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="row" id="searchResultsGrid">
                @forelse ($articles as $index => $article)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="{{ $articleImageUrl($article, 'front/img/top-news-' . (($index % 5) + 1) . '.jpg') }}"
                                alt="{{ $article->title }}">
                            <div class="news-card-body">
                                <span class="news-card-category">{{ $article->category?->name ?: 'News' }}</span>
                                <a class="news-card-title" href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                <p class="news-card-text">{{ $articleExcerpt($article) }}</p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> {{ $articlePublishedAt($article) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="no-results-message" id="searchNoResults">
                            <h4>لم يتم العثور على نتائج للوسوم المحددة.</h4>
                            <p>حاول اختيار وسوم أخرى أو تحديث مصطلح البحث.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($articles->hasPages())
                <nav aria-label="Search results pagination" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $articles->onFirstPage() ? 'disabled' : '' }}">
                            @if ($articles->onFirstPage())
                                <span class="page-link">Previous</span>
                            @else
                                <a class="page-link" href="{{ $articles->previousPageUrl() }}">Previous</a>
                            @endif
                        </li>

                        @for ($page = 1; $page <= $articles->lastPage(); $page++)
                            <li class="page-item {{ $articles->currentPage() === $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $articles->url($page) }}">{{ $page }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $articles->hasMorePages() ? '' : 'disabled' }}">
                            @if ($articles->hasMorePages())
                                <a class="page-link" href="{{ $articles->nextPageUrl() }}">Next</a>
                            @else
                                <span class="page-link">Next</span>
                            @endif
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="footer-logo">
                        <img src="/front/img/logo.png" alt="Logo">
                    </div>
                </div>
                <div class="col-md-6 copyright">
                    <p>© 2026 جميع الحقوق محفوظة لوكالة صوت غزة الإخبارية</p>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <script>
        window.initialSelectedTags = @json($selectedTags->map(fn ($tag) => ['id' => $tag->id, 'name' => $tag->name])->values());
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/front/lib/easing/easing.min.js"></script>
    <script src="/front/lib/slick/slick.min.js"></script>
    <script src="/front/js/main.js"></script>
</body>

</html>
