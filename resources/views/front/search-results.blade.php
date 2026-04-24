<!DOCTYPE html>
<html lang="en">

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

<body>
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
                        <a href="/gaza" class="nav-item nav-link">غزة</a>
                        <a href="/israeli-affairs" class="nav-item nav-link">شؤون إسرائيلية</a>
                        <a href="/arab-world" class="nav-item nav-link">الوطن العربي</a>
                        <a href="/palestine-news" class="nav-item nav-link">أخبار فلسطين</a>
                        <a href="/contact" class="nav-item nav-link">اتصل بنا</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="search-results-hero">
        <div class="container-fluid">
            <div class="category-hero-content">
                <h1 class="category-title">نتائج البحث</h1>
                <p class="category-subtitle">بحث بالوسوم المحددة فقط.</p>
            </div>
        </div>
    </div>

    <div class="search-results-section">
        <div class="container-fluid">
            <div class="search-results-meta mb-4">
                <div class="search-results-label">الوسوم المحددة</div>
                <div class="selected-filter-tags">
                    @forelse ($selectedTags as $tag)
                        <span class="tag-chip selected-tag">{{ $tag->name }}</span>
                    @empty
                        <span class="text-muted">لا توجد وسوم محددة.</span>
                    @endforelse
                </div>
            </div>

            <div class="row">
                @forelse ($articles as $article)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="{{ $article->cover_image ? asset($article->cover_image) : '/front/img/top-news-1.jpg' }}" alt="News Card">
                            <div class="news-card-body">
                                @php
                                    $tags = $articleTags[$article->id] ?? [];
                                @endphp
                                @if (count($tags) > 0)
                                    @foreach ($tags as $tagName)
                                        <span class="news-card-category">{{ $tagName }}</span>
                                    @endforeach
                                @else
                                    <span class="news-card-category">بدون وسوم</span>
                                @endif
                                <a class="news-card-title" href="#">{{ $article->title }}</a>
                                <p class="news-card-text">{{ \Illuminate\Support\Str::limit(strip_tags($article->body), 120) }}</p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($article->published_at)->format('d-M-Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">لا توجد نتائج مطابقة للوسوم المحددة.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $articles->links() }}
            </div>
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

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/front/lib/easing/easing.min.js"></script>
    <script src="/front/lib/slick/slick.min.js"></script>
    <script src="/front/js/main.js"></script>
</body>

</html>
