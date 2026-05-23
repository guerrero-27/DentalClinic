<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DentalCare Clinic')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2C7.5 2 5.5 4 5.5 6.5c0 1.5.7 2.8 1.8 3.7L6 18h1.5l.7-4h3.6l.7 4H14l-1.3-7.8c1.1-.9 1.8-2.2 1.8-3.7C14.5 4 12.5 2 10 2z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-blue-800">DentalCare</span>
                </a>
                <div class="flex items-center gap-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-blue-700 hover:text-blue-900 font-medium text-sm">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">Register</a>
                    @else
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-blue-700 hover:text-blue-900 font-medium text-sm">Admin Panel</a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="text-blue-700 hover:text-blue-900 font-medium text-sm">My Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-gray-500 hover:text-red-600 text-sm font-medium">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    
    <main>@yield('content')</main>

    <footer class="bg-blue-900 text-blue-100 mt-16 py-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="font-bold text-white text-lg">🦷 DentalCare Clinic</p>
            <p class="text-sm mt-1 text-blue-300">Your smile is our priority.</p>
            <p class="text-xs mt-4 text-blue-400">© {{ date('Y') }} DentalCare. All rights reserved.</p>
        </div>
    </footer>

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

    <script>
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