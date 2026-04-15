<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>نتائج البحث - News 24</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Tag search results" name="keywords">
        <meta content="Search results for selected tags" name="description">

        <!-- Favicon -->
        <link href="/front/img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="/front/lib/slick/slick.css" rel="stylesheet">
        <link href="/front/lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="/front/css/style.css" rel="stylesheet">
    </head>
    <body>
        <!-- Top Header Start -->
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
        <!-- Top Header End -->

        <!-- Header Start -->
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
        <!-- Header End -->

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
                    <button type="button" class="tag-chip" data-tag="غزة">غزة</button>
                    <button type="button" class="tag-chip" data-tag="فلسطين">فلسطين</button>
                    <button type="button" class="tag-chip" data-tag="اقتصاد">اقتصاد</button>
                    <button type="button" class="tag-chip" data-tag="تكنولوجيا">تكنولوجيا</button>
                    <button type="button" class="tag-chip" data-tag="صحة">صحة</button>
                    <button type="button" class="tag-chip" data-tag="ثقافة">ثقافة</button>
                    <button type="button" class="tag-chip" data-tag="رياضة">رياضة</button>
                    <button type="button" class="tag-chip" data-tag="تعليم">تعليم</button>
                    <button type="button" class="tag-chip" data-tag="حقوق الإنسان">حقوق الإنسان</button>
                    <button type="button" class="tag-chip" data-tag="دول عربية">دول عربية</button>
                    <button type="button" class="tag-chip" data-tag="شؤون إسرائيلية">شؤون إسرائيلية</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Latest News Strip Start -->
        <div class="latest-news-strip breaking-news-strip">
        <div class="container-fluid">
            <div class="latest-news-container">
                <div class="latest-news-label">
                    <span class="label-icon"><i class="fas fa-circle"></i></span>
                    <span class="label-text">عاجل</span>
                </div>

                <div class="latest-news-ticker">
                    <div class="ticker-content">
                        <a href="#" class="ticker-headline">
                            تطورات جديدة في السياسة الإقليمية: توقعات حول المستجدات القادمة
                        </a>
                    </div>
                    <span class="ticker-meta"><i class="far fa-clock"></i> قبل ساعة</span>
                </div>
            </div>
        </div>
    </div>

        <!-- Latest News Strip End -->

        <!-- Search Results Hero Start -->
        <div class="search-results-hero">
            <div class="container-fluid">
                <div class="category-hero-content">
                    <h1 class="category-title">نتائج البحث</h1>
                    <p class="category-subtitle">عرض الأخبار المرتبطة بالوسوم التي اخترتها. يمكنك تعديل البحث من خلال أي وسم أو بالكتابة في النافذة العلوية.</p>
                </div>
            </div>
        </div>
        <!-- Search Results Hero End -->

        <!-- Search Results Section Start -->
        <div class="search-results-section">
            <div class="container-fluid">
                <div class="search-results-meta">
                    <div class="search-results-label">الوسوم المحددة</div>
                    <div class="selected-filter-tags" id="searchResultsActiveTags"></div>
                </div>
                <div class="row" id="searchResultsGrid"></div>
                <div class="no-results-message" id="searchNoResults" style="display:none;">
                    <h4>لم يتم العثور على نتائج للوسوم المحددة.</h4>
                    <p>حاول اختيار وسوم أخرى أو تحديث مصطلح البحث.</p>
                </div>
            </div>
        </div>
        <!-- Search Results Section End -->

        <!-- Footer Bottom Start -->
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
        <!-- Footer Bottom End -->

        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="/front/lib/easing/easing.min.js"></script>
        <script src="/front/lib/slick/slick.min.js"></script>

        <!-- Template Javascript -->
        <script src="/front/js/main.js"></script>
    </body>
</html>
