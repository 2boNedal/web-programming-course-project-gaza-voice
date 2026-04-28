<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="preload" href="{{ asset('adminlte/dist/css/adminlte.css') }}" as="style" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    @php
        $currentAdmin = Auth::guard('admin')->user();
        $avatarPath = $currentAdmin?->avatar;

        if (is_string($avatarPath)) {
            $avatarPath = ltrim($avatarPath, '/');
            $avatarPath = str_replace('\\', '/', $avatarPath);
            $avatarPath = preg_replace('#^(storage/app/public/|app/public/|public/|storage/)#', '', $avatarPath);
        }

        use Illuminate\Support\Facades\Storage;

        $adminAvatarUrl = null;
        $recentAdminNotifications = collect();
        $unreadAdminNotificationsCount = 0;

        if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
            $adminAvatarUrl = Storage::url($avatarPath);
        }

        if ($currentAdmin) {
            $recentAdminNotifications = $currentAdmin->notifications()
                ->latest()
                ->take(5)
                ->get();

            $unreadAdminNotificationsCount = $currentAdmin->unreadNotifications()->count();
        }
    @endphp
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <!--end::Start Navbar Links-->

                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::Notifications Dropdown Menu-->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell-fill"></i>
                            @if ($unreadAdminNotificationsCount > 0)
                                <span class="navbar-badge badge text-bg-warning">
                                    {{ $unreadAdminNotificationsCount }}
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <span class="dropdown-item dropdown-header">
                                {{ $unreadAdminNotificationsCount }} Unread Notifications
                            </span>
                            @forelse ($recentAdminNotifications as $notification)
                                @php
                                    $notificationIcon = match ($notification->data['event'] ?? null) {
                                        'comment_posted' => 'bi bi-chat-left-text text-primary',
                                        'contact_message_submitted' => 'bi bi-envelope text-success',
                                        'article_submitted_for_review' => 'bi bi-file-earmark-text text-warning',
                                        default => 'bi bi-bell text-secondary',
                                    };
                                @endphp
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('admin.notifications.index') }}" class="dropdown-item">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="{{ $notificationIcon }} mt-1"></i>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="d-flex justify-content-between align-items-start gap-2">
                                                <span class="fw-semibold d-block pe-2">
                                                    {{ $notification->data['title'] ?? 'Notification' }}
                                                </span>
                                                <span class="text-secondary fs-7 flex-shrink-0">
                                                    {{ $notification->created_at?->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="small text-muted mt-1 text-wrap">
                                                {{ $notification->data['message'] ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item text-muted">No notifications found.</span>
                            @endforelse
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.notifications.index') }}" class="dropdown-item dropdown-footer">
                                See All Notifications
                            </a>
                        </div>
                    </li>
                    <!--end::Notifications Dropdown Menu-->

                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="{{ $adminAvatarUrl ?? asset('adminlte/dist/assets/img/user2-160x160.jpg') }}"
                                class="user-image rounded-circle shadow" alt="Admin Image" />
                            <span class="d-none d-md-inline">
                                {{ $currentAdmin?->name ?? 'Admin' }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!--begin::User Image-->
                            <li class="user-header text-bg-primary">
                                <img src="{{ $currentAdmin?->avatar ? asset('storage/' . $currentAdmin->avatar) : asset('adminlte/dist/assets/img/user2-160x160.jpg') }}"
                                    class="rounded-circle shadow" alt="User Image" />

                                <p>
                                    {{ $currentAdmin?->name ?? 'Admin' }}
                                    <small>
                                        Member since {{ $currentAdmin?->created_at?->format('M. Y') ?? '-' }}
                                    </small>
                                </p>
                            </li>
                            <!--end::User Image-->
                            <!--begin::Menu Footer-->
                            <li class="user-footer">
                                @if ($currentAdmin)
                                    <a href="{{ route('admin.admins.show', $currentAdmin) }}"
                                        class="btn btn-outline-secondary">Profile</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST" class="float-end">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Sign out</button>
                                </form>
                            </li>
                            <!--end::Menu Footer-->
                        </ul>
                    </li>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <!--begin::Brand Link-->
                <a href="{{ route('admin.dashboard') }}" class="brand-link">
                    <!--begin::Brand Image-->
                    <img src="{{ asset('adminlte/dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow" />
                    <!--end::Brand Image-->
                    <!--begin::Brand Text-->
                    <span class="brand-text fw-light">Dashboard Voice Gaza</span>
                    <!--end::Brand Text-->
                </a>
                <!--end::Brand Link-->
            </div>
            <!--end::Sidebar Brand-->
            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                        aria-label="Main navigation" data-accordion="false" id="navigation">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.articles.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>Articles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.articles.trashed') }}" class="nav-link">
                                <i class="nav-icon bi bi-trash"></i>
                                <p>Trashed Articles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-folder"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.trashed') }}" class="nav-link">
                                <i class="nav-icon bi bi-folder-x"></i>
                                <p>Trashed Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.tags.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-tags"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.authors.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Authors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.authors.trashed') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-x"></i>
                                <p>Trashed Authors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.admins.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-gear"></i>
                                <p>Admins</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.comments.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-chat-left-text"></i>
                                <p>Comments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contact-messages.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-envelope"></i>
                                <p>Contact Messages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.banners.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-lightning-charge"></i>
                                <p>Breaking News</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.notifications.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-bell"></i>
                                <p>Notifications</p>
                            </a>
                        </li>
                    </ul>
                    <!--end::Sidebar Menu-->
                </nav>
            </div>
            <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->
        <!--begin::App Main-->

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('page_title', 'Admin Dashboard')</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        <footer class="app-footer">
            <strong>Voice Gaza Admin Dashboard</strong>
        </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->

    <!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)-->

    <!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };

        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            const isMobile = window.innerWidth <= 992;

            if (
                sidebarWrapper &&
                OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
                !isMobile
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
</body>

</html>
