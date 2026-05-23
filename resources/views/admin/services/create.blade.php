@extends('layouts.admin')

@section('page-title', 'Add New Service')

@section('content')
    <!-- Page Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 font-medium transition mb-2 text-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Services</span>
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Add New Service</h1>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden max-w-2xl">
        @if($errors->any())
            <div class="bg-red-50 border-b border-red-200 px-6 py-4">
                <div class="flex items-center gap-2 text-red-700">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.services.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Service Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                    <i class="fa-solid fa-tooth mr-1 text-slate-400"></i> Service Name
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-slate-300 transition duration-200 ease-in-out @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}"
                    placeholder="e.g., Dental Cleaning"
                    required
                >
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                    <i class="fa-solid fa-align-left mr-1 text-slate-400"></i> Description
                </label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-slate-300 transition duration-200 ease-in-out resize-none @error('description') border-red-500 @enderror"
                    placeholder="Describe the service..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Price & Duration Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-peso-sign mr-1 text-slate-400"></i> Price (₱)
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">₱</span>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            step="0.01"
                            min="0"
                            class="w-full pl-8 pr-4 py-3 border-2 border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-slate-300 transition duration-200 ease-in-out @error('price') border-red-500 @enderror"
                            value="{{ old('price') }}"
                            placeholder="0.00"
                            required
                        >
                    </div>
                    @error('price')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="duration_minutes" class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-clock mr-1 text-slate-400"></i> Duration (minutes)
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="duration_minutes"
                            id="duration_minutes"
                            min="15"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 hover:border-slate-300 transition duration-200 ease-in-out @error('duration_minutes') border-red-500 @enderror"
                            value="{{ old('duration_minutes') }}"
                            placeholder="30"
                            required
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm">min</span>
                    </div>
                    @error('duration_minutes')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Active Toggle -->
            <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                <label for="is_active" class="flex items-center justify-between cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-toggle-on text-emerald-600 text-lg"></i>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-700">Active Status</span>
                            <p class="text-xs text-slate-500">Enable to make this service available for booking</p>
                        </div>
                    </div>
                    <div class="relative">
                        <input
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            class="sr-only peer"
                            {{ old('is_active') ? 'checked' : '' }}
                        >
                        <div class="w-12 h-7 bg-slate-300 rounded-full peer peer-checked:bg-emerald-500 peer-focus:ring-2 peer-focus:ring-emerald-200 transition-colors"></div>
                        <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full peer-checked:translate-x-5 transition-transform"></div>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 font-semibold transition shadow-lg shadow-blue-200"
                >
                    <i class="fa-solid fa-plus"></i> Create Service
                </button>
                <a
                    href="{{ route('admin.services.index') }}"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-100 text-slate-700 px-6 py-3 rounded-xl hover:bg-slate-200 font-semibold transition border border-slate-200"
                >
                    <i class="fa-solid fa-xmark"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@endsection