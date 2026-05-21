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
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-300 to-blue-500 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                        <i class="fa-solid fa-tooth"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-blue-900">DentalCare</div>
                        <div class="text-xs text-gray-500">Admin Panel</div>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>

                <div class="mt-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</h3>
                    <div class="mt-3 space-y-2">
                        <a href="{{ route('admin.appointments.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.appointments.*') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-calendar-check"></i>
                            Appointments
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-users"></i>
                            Clients
                        </a>

                        <a href="{{ route('admin.services.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.services.*') ? 'active' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            Services
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reports</h3>
                    <div class="mt-3 space-y-2">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <i class="fa-solid fa-chart-line"></i>
                            Analytics
                        </a>

                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <i class="fa-solid fa-file-lines"></i>
                            Reports
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Footer -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        @yield('page-subtitle')
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ date('l, F j, Y') }}</p>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
