<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>News 24 - Free News Website Templates</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Bootstrap Ecommerce Template" name="keywords" />
    <meta content="Bootstrap Ecommerce Template Free Download" name="description" />

    <!-- Favicon -->
    <link href="/front/img/favicon.ico" rel="icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet" />

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="/front/lib/slick/slick.css" rel="stylesheet" />
    <link href="/front/lib/slick/slick-theme.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="/front/css/style.css" rel="stylesheet" />
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
    <!-- Top Header End -->

    <!-- Header Start -->
    <div class="header">
        <div class="container">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="#" class="navbar-brand d-none d-md-block">
                    <img src="/front/img/logo.png" alt="Gaza Voice news agency logo" class="navbar-logo" />
                </a>
                <a href="#" class="navbar-brand d-md-none">MENU</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="/" class="nav-item nav-link active">الرئيسية</a>
                        <a href="/gaza" class="nav-item nav-link">غزة</a>
                        <a href="/israeli-affairs" class="nav-item nav-link">شؤون إسرائيلية</a>
                        <a href="arab-world" class="nav-item nav-link">الوطن العربي</a>
                        <a href="palestine-news" class="nav-item nav-link">أخبار فلسطين</a>
                        <a href="/contact" class="nav-item nav-link">اتصل بنا</a>
                        <a href="#" class="nav-item nav-link nav-search-trigger" id="navSearchToggle"><i
                                class="fas fa-search"></i></a>
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
                    <button type="button" class="search-panel-close" id="searchPanelClose"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="search-panel-body">
                    <div class="search-input-group">
                        <div class="input-with-icon">
                            <input class="search-tag-input" id="searchTagInput" type="text"
                                placeholder="اكتب لاقتراح الوسوم..." autocomplete="off">
                            <button type="button" class="search-input-icon" id="searchInputIcon"><i
                                    class="fas fa-search"></i></button>
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
    <!-- Header End -->
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
    <!-- Top News Start -->
    <div class="top-news modern-top-news">
        <div class="container-fluid">
            <div class="row g-4">
                <!-- Featured Main News -->
                <div class="col-lg-6">
                    <div class="top-news-card featured-card">
                        <img src="/front/img/top-news-1.jpg" alt="خبر رئيسي" />
                        <div class="overlay"></div>
                        <div class="top-news-content">
                            <span class="news-card-category">غزة</span>
                            <div class="news-meta">
                                <span><i class="far fa-clock"></i> 05-Feb-2020</span>
                            </div>
                            <a href="#" class="news-title">
                                تصاعد الأحداث في غزة وسط متابعة ميدانية متواصلة وتغطية إخبارية
                                مباشرة
                            </a>
                            <p class="news-excerpt">
                                متابعة سريعة لأبرز التطورات الميدانية والإنسانية مع تغطية
                                دقيقة ومحتوى واضح يلفت القارئ.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Secondary News Grid -->
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="top-news-card small-card">
                                <img src="/front/img/top-news-2.jpg" alt="خبر" />
                                <div class="overlay"></div>
                                <div class="top-news-content">
                                    <span class="news-badge small-badge">فلسطين</span>
                                    <div class="news-meta">
                                        <span><i class="far fa-clock"></i> 05-Feb-2020</span>
                                    </div>
                                    <a href="#" class="news-title">
                                        تطورات ميدانية متسارعة شمال القطاع
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="top-news-card small-card">
                                <img src="/front/img/top-news-3.jpg" alt="خبر" />
                                <div class="overlay"></div>
                                <div class="top-news-content">
                                    <span class="news-badge small-badge">شؤون إسرائيلية</span>
                                    <div class="news-meta">
                                        <span><i class="far fa-clock"></i> 05-Feb-2020</span>
                                    </div>
                                    <a href="#" class="news-title">
                                        قراءات سياسية جديدة حول تطورات المشهد
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="top-news-card small-card">
                                <img src="/front/img/top-news-4.jpg" alt="خبر" />
                                <div class="overlay"></div>
                                <div class="top-news-content">
                                    <span class="news-badge small-badge">الوطن العربي</span>
                                    <div class="news-meta">
                                        <span><i class="far fa-clock"></i> 05-Feb-2020</span>
                                    </div>
                                    <a href="#" class="news-title">
                                        مواقف عربية متباينة تجاه آخر المستجدات
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="top-news-card small-card">
                                <img src="/front/img/top-news-5.jpg" alt="خبر" />
                                <div class="overlay"></div>
                                <div class="top-news-content">
                                    <span class="news-badge small-badge">غزة</span>
                                    <div class="news-meta">
                                        <span><i class="far fa-clock"></i> 05-Feb-2020</span>
                                    </div>
                                    <a href="#" class="news-title">
                                        تقارير إنسانية توثق الأوضاع داخل القطاع
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Secondary News Grid -->
            </div>
        </div>
    </div>
    <!-- Top News End -->

    <!-- Service Bar Start -->
    <!-- Service Bar Start -->
    <div class="service-bar premium-service-bar">
        <div class="container-fluid">
            <div class="row g-4 service-widgets">
                <!-- Weather Widget -->
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
                                <span class="forecast-temp" id="weatherTodayTemp">28°</span>
                                <span class="forecast-status" id="weatherTodayStatus">مشمس</span>
                            </div>

                            <div class="forecast-box">
                                <span class="forecast-day">غدًا</span>
                                <div class="forecast-icon">
                                    <i class="fas fa-cloud-sun"></i>
                                </div>
                                <span class="forecast-temp" id="weatherTomorrowTemp">25°</span>
                                <span class="forecast-status" id="weatherTomorrowStatus">غائم جزئيًا</span>
                            </div>

                            <div class="forecast-box">
                                <span class="forecast-day">بعد غد</span>
                                <div class="forecast-icon">
                                    <i class="fas fa-cloud-rain"></i>
                                </div>
                                <span class="forecast-temp" id="weatherAfterTemp">23°</span>
                                <span class="forecast-status" id="weatherAfterStatus">أمطار خفيفة</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Currency Widget -->
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
    <!-- Service Bar End -->
    <!-- Service Bar End -->

    <!-- Main News Start -->
    <div class="main-news">
        <div class="container-fluid">
            <div class="secondary-news-section">
                <div class="section-header">
                    <h2>أخبار إضافية</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-1.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">شؤون إسرائيلية</span>
                                <a class="news-card-title" href="">تطورات جديدة في الشؤون الإسرائيلية</a>
                                <p class="news-card-text">
                                    شهدت الأوضاع السياسية تطورات مهمة مع إعلان اتفاقيات سلام
                                    جديدة في المنطقة.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 15-Mar-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-2.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">الوطن العربي</span>
                                <a class="news-card-title" href="">ارتفاع أسعار النفط يؤثر على الاقتصاد العالمي</a>
                                <p class="news-card-text">
                                    أدى التوتر في أسواق الطاقة إلى زيادة ملحوظة في أسعار النفط
                                    الخام عالمياً.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 12-Mar-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-3.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">أخبار فلسطين</span>
                                <a class="news-card-title" href="">مهرجان ثقافي يجمع الفنانين العرب</a>
                                <p class="news-card-text">
                                    استضاف المهرجان الدولي مجموعة من أبرز الفنانين والمبدعين من
                                    مختلف الدول العربية.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 10-Mar-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-4.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">غزة</span>
                                <a class="news-card-title" href="">فوز المنتخب الوطني في بطولة آسيا</a>
                                <p class="news-card-text">
                                    حقق المنتخب الوطني فوزاً تاريخياً في الدور نصف النهائي
                                    لبطولة آسيا لكرة القدم.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 08-Mar-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-5.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">شؤون إسرائيلية</span>
                                <a class="news-card-title" href="">تقدم تكنولوجي جديد في مجال الذكاء الاصطناعي</a>
                                <p class="news-card-text">
                                    أعلنت شركة تقنية رائدة عن نموذج ذكاء اصطناعي متقدم يغير مجال
                                    الحوسبة.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 05-Mar-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-1.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">أخبار فلسطين</span>
                                <a class="news-card-title" href="">حملة توعية صحية لمكافحة الأمراض المعدية</a>
                                <p class="news-card-text">
                                    أطلقت وزارة الصحة حملة شاملة للتوعية بأهمية الوقاية من
                                    الأمراض المعدية.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 03-Mar-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-2.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">غزة</span>
                                <a class="news-card-title" href="">عودة الحوار الإنساني تدفع للتفاهمات</a>
                                <p class="news-card-text">
                                    يأتي ذلك في ظل جهود تعزيز التهدئة وفتح قنوات جديدة للدعم
                                    الإنساني.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 01-Mar-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-3.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">الوطن العربي</span>
                                <a class="news-card-title" href="">مناقشات لتحديث قوانين الإعلام العربية</a>
                                <p class="news-card-text">
                                    يجري بحث مقترحات لتعزيز حرية التعبير وتطوير البيئة الإعلامية
                                    في المنطقة.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 28-Feb-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-4.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">شؤون إسرائيلية</span>
                                <a class="news-card-title" href="">تحليل أمني يسلط الضوء على الحدود</a>
                                <p class="news-card-text">
                                    تغطي التقارير الجديدة تأثير الإجراءات الأمنية على الحركة
                                    المدنية والمجتمعات المحلية.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 25-Feb-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-5.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">أخبار فلسطين</span>
                                <a class="news-card-title" href="">مشروع إسكان جديد يدعم الأسر المتضررة</a>
                                <p class="news-card-text">
                                    المبادرة توفر وحدات سكنية مؤقتة وتدعم إعادة الإعمار في
                                    مناطق متضررة.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 22-Feb-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-1.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">غزة</span>
                                <a class="news-card-title" href="">مساعدات طبية دولية تصل إلى القطاع</a>
                                <p class="news-card-text">
                                    تشهد المستشفيات تحسناً مع وصول شحنات الأدوية والمعدات
                                    الطبية الجديدة.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 20-Feb-2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card">
                            <img src="/front/img/top-news-2.jpg" alt="News Card" />
                            <div class="news-card-body">
                                <span class="news-card-category">الوطن العربي</span>
                                <a class="news-card-title" href="">تعافي سوق العمل يعزز الثقة الاستثمارية</a>
                                <p class="news-card-text">
                                    صعود مؤشرات التوظيف يدفع المستثمرين لمراجعة خططهم في المنطقة.
                                </p>
                                <span class="news-card-meta"><i class="far fa-clock"></i> 18-Feb-2024</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End -->

    <!-- Footer Bottom Start -->
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
    <!-- Footer Bottom End -->

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/front/lib/easing/easing.min.js"></script>
    <script src="/front/lib/slick/slick.min.js"></script>

    <!-- Template Javascript -->
    <script src="front/js/main.js"></script>
</body>

</html>