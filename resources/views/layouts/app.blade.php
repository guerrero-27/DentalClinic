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

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                ✅ {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
                ❌ {{ session('error') }}
            </div>
        </div>
    @endif

    <main>@yield('content')</main>

    <footer class="bg-blue-900 text-blue-100 mt-16 py-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="font-bold text-white text-lg">🦷 DentalCare Clinic</p>
            <p class="text-sm mt-1 text-blue-300">Your smile is our priority.</p>
            <p class="text-xs mt-4 text-blue-400">© {{ date('Y') }} DentalCare. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>