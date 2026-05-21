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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-white to-blue-50">
            <!-- Background Decoration -->
            <div class="fixed top-0 right-0 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -z-10"></div>
            <div class="fixed bottom-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -z-10"></div>

            <!-- Header -->
            <div class="mb-8 text-center">
                <a href="/" class="inline-block">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center text-white text-xl font-bold">
                            🦷
                        </div>
                        <h2 class="text-2xl font-bold text-blue-900">DentalCare</h2>
                    </div>
                </a>
            </div>

            <!-- Main Content Container -->
            <div class="w-full sm:max-w-md">
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                    <div class="px-8 py-8">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-6 text-sm text-gray-500">
                    <p>&copy; 2026 DentalCare Clinic. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>
