@php
    $navbarCategories = $navbarCategories ?? collect();
    $categoryHeroDescriptions = [
        'أخبار فلسطين' => 'آخر الأخبار والتطورات الفلسطينية المرتبطة بالحرب على غزة وتداعياتها السياسية والميدانية.',
        'غزة' => 'تغطية مستمرة لأخبار غزة الميدانية والإنسانية في ظل الحرب والحصار ومعاناة السكان.',
        'شؤون إسرائيلية' => 'متابعة للتطورات الإسرائيلية السياسية والعسكرية والإعلامية المرتبطة بالحرب على غزة.',
        'الوطن العربي' => 'رصد للمواقف والتحركات العربية تجاه الحرب على غزة وانعكاساتها على المنطقة.',
    ];
    $categoryHeroSubtitle = $categoryHeroDescriptions[$category->name] ?? 'متابعة للتطورات الإسرائيلية السياسية والعسكرية والإعلامية المرتبطة بالحرب على غزة.';
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
<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>{{ $category->name }} - News 24</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="{{ $category->name }}" name="keywords" />
    <meta content="Latest published articles in {{ $category->name }}" name="description" />

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
                        @foreach ($navbarCategories as $navbarCategory)
                            <a href="{{ route('categories.show', $navbarCategory->slug) }}"
                                class="nav-item nav-link {{ $currentCategorySlug === $navbarCategory->slug ? 'active' : '' }}">
                                {{ $navbarCategory->name }}
                            </a>
                        @endforeach
                        <a href="/contact" class="nav-item nav-link">اتصل بنا</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="category-hero">
        <div class="container-fluid">
            <div class="category-hero-content">
                <h1 class="category-title">{{ $category->name }}</h1>
                <p class="category-subtitle">{{ $categoryHeroSubtitle }}</p>
            </div>
        </div>
    </div>

    <div class="category-news-section">
        <div class="container">
            <div class="row">
                @forelse ($articles as $index => $article)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="{{ $articleImageUrl($article, 'front/img/top-news-' . (($index % 5) + 1) . '.jpg') }}"
                                alt="{{ $article->title }}" />
                            <div class="news-card-body">
                                @if ($article->tags->isNotEmpty())
                                    <div class="mb-2">
                                        @foreach ($article->tags as $tag)
                                            <span class="news-card-category mr-1">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <a class="news-card-title" href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                                <p class="news-card-text">
                                    {{ $articleExcerpt($article) }}
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i>
                                    {{ $articlePublishedAt($article) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="news-card">
                            <div class="news-card-body text-center">
                                <p class="news-card-text mb-0">No published articles available in this category.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($articles->hasPages())
                <nav aria-label="Category articles pagination" class="mt-4">
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
</body>

</html>
