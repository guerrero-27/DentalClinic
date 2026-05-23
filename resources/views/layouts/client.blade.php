<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Client Dashboard - DentalCare')</title>
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

        .mobile-menu-btn {
            display: none;
        }

        .sidebar {
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
        }

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

        @media (max-width: 639px) {
            .main-content {
                padding: 1rem !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- Flash Messages Modal -->
    @if(session('success') || $errors->any())
        <div id="flash-modal" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="modal-content">
                @if(session('success'))
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-check text-emerald-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Success!</h3>
                        <p class="text-gray-600">{{ session('success') }}</p>
                    </div>
                @elseif($errors->any())
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-circle-exclamation text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Oops!</h3>
                        <ul class="text-gray-600 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <button onclick="closeModal()" class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition">
                        Got it
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col">
            <!-- Logo & Brand -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-tooth text-white"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-blue-900 text-lg">DentalCare</h1>
                        <p class="text-xs text-gray-500">Client Portal</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <!-- Main Section -->
                <div class="mb-4">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:block">Main Menu</h3>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('client.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('client.dashboard') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-house w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('client.appointments.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('client.appointments.index') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-calendar-alt w-5 text-center"></i>
                            <span>My Appointments</span>
                        </a>
                        <a href="{{ route('client.appointments.create') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('client.appointments.create') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-plus w-5 text-center"></i>
                            <span>Book Appointment</span>
                        </a>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="mt-4 md:mt-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:block">Account</h3>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('client.profile') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('client.profile') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-user w-5 text-center"></i>
                            <span>My Profile</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition text-red-600 hover:bg-red-50">
                            @csrf
                            <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                            <button type="submit" class="w-full text-left">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Footer -->
            <div class="px-4 py-4 border-t border-gray-100">
                <div class="flex items-center gap-3 px-4 py-3 bg-blue-50 rounded-lg">
                    <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-800 text-sm truncate">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-4 md:px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleSidebar()" class="mobile-menu-btn w-10 h-10 items-center justify-center rounded-lg hover:bg-gray-100 transition">
                        <i class="fa-solid fa-bars text-gray-600"></i>
                    </button>

                    <!-- Page Title (Desktop) -->
                    <div class="hidden sm:block">
                        <h2 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center gap-3">
                        <!-- Notifications -->
                        <button class="relative w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
                            <i class="fa-solid fa-bell text-gray-600"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="main-content flex-1 overflow-y-auto p-4 md:p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }

        // Close sidebar on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        // Modal Functions
        function closeModal() {
            const modal = document.getElementById('flash-modal');
            const content = document.getElementById('modal-content');
            if (content) {
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
            }
            setTimeout(() => {
                if (modal) modal.remove();
            }, 300);
        }

        // Auto-show modal on page load
        window.addEventListener('load', () => {
            const modal = document.getElementById('flash-modal');
            const content = document.getElementById('modal-content');
            if (modal && content) {
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 100);
            }
        });
    </script>
</body>
</html>