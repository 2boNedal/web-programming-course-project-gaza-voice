@php
    $navbarCategories = $navbarCategories ?? collect();
    $banners = $banners ?? collect();

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
    <title>وكالة صوت غزة الإخبارية</title>
    <link href="/front/img/logo.png" rel="icon" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="وكالة صوت غزة الإخبارية" name="keywords" />
    <meta content="آخر الأخبار والتغطيات المنشورة من وكالة صوت غزة الإخبارية" name="description" />

    <link href="/front/img/favicon.ico" rel="icon" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet" />

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="/front/lib/slick/slick.css" rel="stylesheet" />
    <link href="/front/lib/slick/slick-theme.css" rel="stylesheet" />

    <link href="/front/css/style.css" rel="stylesheet" />
</head>

<body class="public-rtl homepage-rtl">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="/front/img/logo.png" alt="شعار صوت غزة" />
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
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                </div>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="container">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="{{ url('/') }}" class="navbar-brand d-none d-md-block">
                    <img src="/front/img/logo.png" alt="شعار صوت غزة" class="navbar-logo" />
                </a>
                <a href="#" class="navbar-brand d-md-none">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="{{ url('/') }}" class="nav-item nav-link active">الرئيسية</a>
                        @foreach ($navbarCategories as $navbarCategory)
                            <a href="{{ route('categories.show', $navbarCategory->slug) }}" class="nav-item nav-link">
                                {{ $navbarCategory->name }}
                            </a>
                        @endforeach
                        <a href="{{ route('contact.create') }}" class="nav-item nav-link">اتصل بنا</a>
                        <a href="#" class="nav-item nav-link nav-search-trigger" id="navSearchToggle"><i class="fas fa-search"></i></a>
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

    @if ($banners->isNotEmpty())
        <div class="latest-news-strip breaking-news-strip">
            <div class="container-fluid">
                <div class="latest-news-container">
                    <div class="latest-news-label">
                        <span class="label-icon"><i class="fas fa-circle"></i></span>
                        <span class="label-text">عاجل</span>
                    </div>

                    <div class="latest-news-ticker">
                        <div class="ticker-content">
                            <span class="ticker-headline" id="breakingNewsHeadline" data-source="banners">{{ $banners->first()->title }}</span>
                        </div>
                        <span class="ticker-meta"><i class="far fa-clock"></i> الآن</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="top-news modern-top-news">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-lg-6">
                    @if ($featuredArticle)
                        <div class="top-news-card featured-card">
                            <img src="{{ $articleImageUrl($featuredArticle, 'front/img/top-news-1.jpg') }}" alt="{{ $featuredArticle->title }}" />
                            <div class="overlay"></div>
                            <div class="top-news-content">
                                <span class="news-card-category">{{ $featuredArticle->category?->name ?: 'أخبار' }}</span>
                                <div class="news-meta">
                                    <span><i class="far fa-clock"></i> {{ $articlePublishedAt($featuredArticle) }}</span>
                                </div>
                                <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="news-title">
                                    {{ $featuredArticle->title }}
                                </a>
                                <p class="news-excerpt">{{ $articleExcerpt($featuredArticle, 170) }}</p>
                            </div>
                        </div>
                    @else
                        <div class="top-news-card featured-card">
                            <img src="/front/img/top-news-1.jpg" alt="لا توجد أخبار منشورة" />
                            <div class="overlay"></div>
                            <div class="top-news-content">
                                <span class="news-card-category">أخبار</span>
                                <a href="#" class="news-title">لا توجد أخبار منشورة حالياً</a>
                                <p class="news-excerpt">سيتم عرض المقالات المنشورة هنا فور توفرها.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-6">
                    <div class="row g-4">
                        @forelse ($sideArticles as $index => $article)
                            <div class="col-md-6">
                                <div class="top-news-card small-card">
                                    <img src="{{ $articleImageUrl($article, 'front/img/top-news-' . (($index % 4) + 2) . '.jpg') }}" alt="{{ $article->title }}" />
                                    <div class="overlay"></div>
                                    <div class="top-news-content">
                                        <span class="news-badge small-badge">{{ $article->category?->name ?: 'أخبار' }}</span>
                                        <div class="news-meta">
                                            <span><i class="far fa-clock"></i> {{ $articlePublishedAt($article) }}</span>
                                        </div>
                                        <a href="{{ route('articles.show', $article->slug) }}" class="news-title">{{ $article->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="top-news-card small-card">
                                    <img src="/front/img/top-news-2.jpg" alt="لا توجد أخبار إضافية" />
                                    <div class="overlay"></div>
                                    <div class="top-news-content">
                                        <span class="news-badge small-badge">أخبار</span>
                                        <a href="#" class="news-title">لا توجد بطاقات أخبار إضافية حالياً</a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="service-bar premium-service-bar">
        <div class="container-fluid">
            <div class="row g-4 service-widgets">
                <div class="col-lg-6">
                    <div class="service-card weather-card">
                        <div class="service-card-top">
                            <div class="service-title">
                                <span class="service-icon"><i class="fas fa-cloud-sun"></i></span>
                                <div>
                                    <h3>الطقس</h3>
                                    <p>متابعة سريعة لطقس المدن الفلسطينية</p>
                                </div>
                            </div>

                            <div class="selector-trigger" id="weatherTrigger">
                                <span class="selector-label" id="weatherLocation">غزة</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>

                            <div class="custom-dropdown" id="weatherDropdown">
                                <ul class="dropdown-list">
                                    <li data-location="gaza">غزة</li>
                                    <li data-location="jerusalem">القدس</li>
                                    <li data-location="ramallah">رام الله</li>
                                    <li data-location="bethlehem">بيت لحم</li>
                                    <li data-location="hebron">الخليل</li>
                                    <li data-location="jenin">جنين</li>
                                    <li data-location="nablus">نابلس</li>
                                </ul>
                            </div>
                        </div>

                        <div class="forecast-grid">
                            <div class="forecast-box active-day">
                                <span class="forecast-day">اليوم</span>
                                <div class="forecast-icon"><i class="fas fa-sun"></i></div>
                                <span class="forecast-temp" id="weatherTodayTemp">28&deg;</span>
                                <span class="forecast-status" id="weatherTodayStatus">مشمس</span>
                            </div>

                            <div class="forecast-box">
                                <span class="forecast-day">غدًا</span>
                                <div class="forecast-icon"><i class="fas fa-cloud-sun"></i></div>
                                <span class="forecast-temp" id="weatherTomorrowTemp">25&deg;</span>
                                <span class="forecast-status" id="weatherTomorrowStatus">غائم جزئيًا</span>
                            </div>

                            <div class="forecast-box">
                                <span class="forecast-day">بعد غد</span>
                                <div class="forecast-icon"><i class="fas fa-cloud-rain"></i></div>
                                <span class="forecast-temp" id="weatherAfterTemp">23&deg;</span>
                                <span class="forecast-status" id="weatherAfterStatus">أمطار خفيفة</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="service-card currency-card">
                        <div class="service-card-top">
                            <div class="service-title">
                                <span class="service-icon"><i class="fas fa-coins"></i></span>
                                <div>
                                    <h3>أسعار العملات</h3>
                                    <p>متابعة أسعار الشراء والبيع مقابل الشيكل</p>
                                </div>
                            </div>

                            <div class="selector-trigger" id="currencyTrigger">
                                <span class="selector-label" id="currencyCode">الدولار الأمريكي</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>

                            <div class="custom-dropdown" id="currencyDropdown">
                                <ul class="dropdown-list">
                                    <li data-currency="usd">الدولار الأمريكي</li>
                                    <li data-currency="eur">اليورو</li>
                                    <li data-currency="gbp">الجنيه الإسترليني</li>
                                    <li data-currency="jod">الدينار الأردني</li>
                                    <li data-currency="egp">الجنيه المصري</li>
                                </ul>
                            </div>
                        </div>

                        <div class="rates-grid">
                            <div class="rate-box buy-rate">
                                <span class="rate-label">شراء</span>
                                <span class="rate-value" id="buyRate">3.62</span>
                                <span class="rate-unit">شيكل</span>
                            </div>

                            <div class="rate-box sell-rate">
                                <span class="rate-label">بيع</span>
                                <span class="rate-value" id="sellRate">3.66</span>
                                <span class="rate-unit">شيكل</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-news">
        <div class="container-fluid">
            <div class="secondary-news-section">
                <div class="section-header">
                    <h2>أخبار إضافية</h2>
                </div>
                <div class="row">
                    @forelse ($olderArticles as $index => $article)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="news-card">
                                <img src="{{ $articleImageUrl($article, 'front/img/top-news-' . (($index % 5) + 1) . '.jpg') }}" alt="{{ $article->title }}" />
                                <div class="news-card-body">
                                    <span class="news-card-category">{{ $article->category?->name ?: 'أخبار' }}</span>
                                    <a class="news-card-title" href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                    <p class="news-card-text">{{ $articleExcerpt($article) }}</p>
                                    <span class="news-card-meta"><i class="far fa-clock"></i> {{ $articlePublishedAt($article) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="news-card">
                                <div class="news-card-body text-center">
                                    <p class="news-card-text mb-0">لا توجد أخبار إضافية منشورة حالياً.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($olderArticles->hasPages())
                    <nav aria-label="Homepage articles pagination" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $olderArticles->onFirstPage() ? 'disabled' : '' }}">
                                @if ($olderArticles->onFirstPage())
                                    <span class="page-link">Previous</span>
                                @else
                                    <a class="page-link" href="{{ $olderArticles->previousPageUrl() }}">Previous</a>
                                @endif
                            </li>

                            @for ($page = 1; $page <= $olderArticles->lastPage(); $page++)
                                <li class="page-item {{ $olderArticles->currentPage() === $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $olderArticles->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor

                            <li class="page-item {{ $olderArticles->hasMorePages() ? '' : 'disabled' }}">
                                @if ($olderArticles->hasMorePages())
                                    <a class="page-link" href="{{ $olderArticles->nextPageUrl() }}">Next</a>
                                @else
                                    <span class="page-link">Next</span>
                                @endif
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="footer-logo">
                        <img src="/front/img/logo.png" alt="شعار صوت غزة" />
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
        window.initialSelectedTags = [];
        window.breakingNewsItems = @json($banners->pluck('title')->values());
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/front/lib/easing/easing.min.js"></script>
    <script src="/front/lib/slick/slick.min.js"></script>
    <script src="/front/js/main.js"></script>
</body>

</html>
