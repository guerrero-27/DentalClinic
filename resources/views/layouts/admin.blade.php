<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - DentalCare')</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .sidebar-link.active {
            background-color: rgba(37, 99, 235, 0.1);
            border-left: 4px solid #2563eb;
            color: #1e40af;
            font-weight: 600;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
        }

        /* Sidebar transitions */
        .sidebar {
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
        }

        /* Hide sidebar on mobile by default */
        @media (max-width: 1023px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 50;
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .mobile-menu-btn {
                display: flex;
            }
        }

        /* Responsive utilities */
        @media (max-width: 639px) {
            .main-content {
                padding: 1rem !important;
            }
            .header-title {
                font-size: 1.25rem !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="p-4 md:p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                            <i class="fa-solid fa-tooth"></i>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-blue-900">DentalCare</div>
                            <div class="text-xs text-gray-500 hidden sm:block">Admin Panel</div>
                        </div>
                    </a>
                    <!-- Mobile Close Button -->
                    <button onclick="closeSidebar()" class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <div class="mt-4 md:mt-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:block">Management</h3>
                    <div class="mt-2 md:mt-3 space-y-1 md:space-y-2">
                        <a href="{{ route('admin.appointments.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.appointments.*') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                            <span>Appointments</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-users w-5 text-center"></i>
                            <span>Clients</span>
                        </a>

                        <a href="{{ route('admin.dentists.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dentists.*') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-user-doctor w-5 text-center"></i>
                            <span>Dentists</span>
                        </a>

                        <a href="{{ route('admin.services.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.services.*') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-screwdriver-wrench w-5 text-center"></i>
                            <span>Services</span>
                        </a>
                    </div>
                </div>

                <div class="mt-4 md:mt-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:block">Reports</h3>
                    <div class="mt-2 md:mt-3 space-y-1 md:space-y-2">
                        <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.analytics') ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-chart-line w-5 text-center"></i>
                            <span>Analytics</span>
                        </a>

                        <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.reports') ? 'bg-blue-50 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-file-lines w-5 text-center"></i>
                            <span>Reports</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Footer -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center gap-3 mb-3 md:mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 md:px-6 lg:px-8 py-3 md:py-4 flex justify-between items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button onclick="openSidebar()" class="mobile-menu-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-600">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>

                    <div class="flex-1 min-w-0">
                        <h1 class="header-title text-xl md:text-2xl font-bold text-gray-900 truncate">@yield('page-title', 'Dashboard')</h1>
                        @yield('page-subtitle')
                    </div>

                    <div class="hidden sm:block text-right flex-shrink-0">
                        <p class="text-sm text-gray-500">{{ date('l, F j, Y') }}</p>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="main-content flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ✅ Toast Notifications --}}
    @if(session('success'))
    <div id="toast-success" class="fixed top-4 right-4 z-50 flex items-center gap-3 px-5 py-4 bg-white border-l-4 border-green-500 rounded-lg shadow-xl transform translate-x-full transition-transform duration-500 ease-in-out">
        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
            <i class="fa-solid fa-check text-green-600 text-lg"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-900">Success</p>
            <p class="text-sm text-gray-600 truncate">{{ session('success') }}</p>
        </div>
        <button onclick="closeToast('toast-success')" class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="toast-error" class="fixed top-4 right-4 z-50 flex items-center gap-3 px-5 py-4 bg-white border-l-4 border-red-500 rounded-lg shadow-xl transform translate-x-full transition-transform duration-500 ease-in-out">
        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
            <i class="fa-solid fa-exclamation text-red-600 text-lg"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-900">Error</p>
            <p class="text-sm text-gray-600 truncate">{{ session('error') }}</p>
        </div>
        <button onclick="closeToast('toast-error')" class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 transition">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif
        </div>
    </div>

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        // ✅ Toast Auto-Dismiss
        function closeToast(id) {
            const toast = document.getElementById(id);
            if (toast) {
                toast.classList.add('translate-x-full');
                toast.classList.remove('translate-x-0');
                setTimeout(() => toast.remove(), 500);
            }
        }

        setTimeout(() => {
            ['toast-success', 'toast-error'].forEach(id => {
                const toast = document.getElementById(id);
                if (toast) closeToast(id);
            });
        }, 4000);

        window.addEventListener('load', () => {
            ['toast-success', 'toast-error'].forEach(id => {
                const toast = document.getElementById(id);
                if (toast) {
                    setTimeout(() => {
                        toast.classList.remove('translate-x-full');
                        toast.classList.add('translate-x-0');
                    }, 100);
                }
            });
        });
    </script>
</body>
</html>
