@extends('layouts.admin')
@section('page-title', 'Edit Service')
@section('content')
    <div class="max-w-2xl">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold mb-2">Service Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                    value="{{ old('name', $service->name) }}"
                    required
                >
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold mb-2">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('description') border-red-500 @enderror"
                >{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="price" class="block text-sm font-semibold mb-2">Price (₱)</label>
                    <input 
                        type="number" 
                        name="price" 
                        id="price" 
                        step="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('price') border-red-500 @enderror"
                        value="{{ old('price', $service->price) }}"
                        required
                    >
                    @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="duration_minutes" class="block text-sm font-semibold mb-2">Duration (minutes)</label>
                    <input 
                        type="number" 
                        name="duration_minutes" 
                        id="duration_minutes" 
                        min="15"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('duration_minutes') border-red-500 @enderror"
                        value="{{ old('duration_minutes', $service->duration_minutes) }}"
                        required
                    >
                    @error('duration_minutes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="is_active" class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active"
                        class="w-4 h-4"
                        {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                    >
                    <span class="ml-2 text-sm font-semibold">Active</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700"
                >
                    Update Service
                </button>
                <a 
                    href="{{ route('admin.services.index') }}" 
                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
