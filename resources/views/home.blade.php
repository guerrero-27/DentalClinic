@extends('layouts.app')
@section('title', 'DentalCare — Home')
@section('content')

<!-- Hero -->
<section class="bg-gradient-to-br from-blue-700 to-blue-900 text-white py-24">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">Your Smile, Our Priority 🦷</h1>
        <p class="text-blue-200 text-lg max-w-2xl mx-auto mb-8">
            Professional dental care you can trust. Book your appointment online — fast, easy, and hassle-free.
        </p>
        @guest
            <a href="{{ route('register') }}" class="bg-white text-blue-700 font-bold px-8 py-3 rounded-xl hover:bg-blue-50 transition text-lg mr-3">
                Book Now
            </a>
            <a href="{{ route('login') }}" class="border border-white text-white px-8 py-3 rounded-xl hover:bg-white hover:text-blue-700 transition text-lg">
                Login
            </a>
        @else
            <a href="{{ route('client.appointments.create') }}" class="bg-white text-blue-700 font-bold px-8 py-3 rounded-xl hover:bg-blue-50 transition text-lg">
                Book an Appointment
            </a>
        @endguest
    </div>
</section>

<!-- Services -->
<section class="py-20 max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-blue-900 text-center mb-2">Our Services</h2>
    <p class="text-gray-500 text-center mb-12">Comprehensive dental care for the whole family</p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($services as $service)
        <div class="bg-white rounded-2xl border border-blue-100 p-6 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-blue-900 text-lg mb-1">{{ $service->name }}</h3>
            <p class="text-gray-500 text-sm mb-3">{{ $service->description }}</p>
            <div class="flex justify-between items-center">
                <span class="text-blue-600 font-bold">₱{{ number_format($service->price, 2) }}</span>
                <span class="text-gray-400 text-xs">{{ $service->duration_minutes }} mins</span>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Why Choose Us -->
<section class="bg-blue-50 py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-blue-900 mb-12">Why Choose DentalCare?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div><div class="text-4xl mb-3">🏥</div><h3 class="font-bold text-blue-800 mb-2">Modern Equipment</h3><p class="text-gray-500 text-sm">State-of-the-art dental technology for precise and comfortable treatments.</p></div>
            <div><div class="text-4xl mb-3">👨‍⚕️</div><h3 class="font-bold text-blue-800 mb-2">Expert Dentists</h3><p class="text-gray-500 text-sm">Board-certified professionals with years of clinical experience.</p></div>
            <div><div class="text-4xl mb-3">📅</div><h3 class="font-bold text-blue-800 mb-2">Easy Booking</h3><p class="text-gray-500 text-sm">Book appointments online anytime — no phone calls needed.</p></div>
        </div>
    </div>
</section>

@endsection