<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center relative">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img
                    src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
                    alt="Dental Clinic"
                    class="w-full h-full object-cover"
                />
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-blue-800/70 to-blue-900/80"></div>
            </div>

            <!-- Login Card -->
            <div class="relative z-10 w-full sm:max-w-md px-4">
                <div class="bg-white/95 backdrop-blur-sm shadow-2xl rounded-2xl overflow-hidden">
                    <!-- Card Header with Logo -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 text-center">
                        <div class="flex justify-center mb-3">
                            <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v4m0 4v8m0 4h8m-8-4h8m-8 0a8 8 0 1116 0H4z"/>
                                </svg>
                            </div>
                        </div>
                        <h1 class="text-2xl font-bold text-white tracking-wide">DentalCare</h1>
                        <p class="text-blue-100 text-sm mt-1">Your Smile, Our Priority</p>
                    </div>

                    <!-- Form Content -->
                    <div class="px-8 py-8">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-6 text-sm text-white/80">
                    <p>&copy; 2026 DentalCare Clinic. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>