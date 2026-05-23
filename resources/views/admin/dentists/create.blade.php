@extends('layouts.admin')

@section('page-title', 'Add Dentist')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.dentists.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 text-sm font-medium">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Dentists
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">New Dentist</h2>
            <p class="text-gray-500 text-sm mt-1">Fill in the details to add a new dental professional</p>
        </div>

        <form action="{{ route('admin.dentists.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Profile Image -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Photo</label>
                    <div class="flex items-center gap-6">
                        <div id="imagePreviewContainer" class="relative">
                            <div class="w-32 h-32 rounded-xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                                <i class="fa-solid fa-camera text-gray-400 text-2xl"></i>
                            </div>
                        </div>
                        <div>
                            <input type="file" name="image" id="imageInput" accept="image/*" class="hidden">
                            <label for="imageInput" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-50 transition">
                                <i class="fa-solid fa-upload"></i>
                                Upload Photo
                            </label>
                            <p class="text-xs text-gray-500 mt-2">JPEG, PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birthdate -->
                <div>
                    <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('birthdate')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="lg:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Working Hours -->
                <div>
                    <label for="working_start" class="block text-sm font-medium text-gray-700 mb-2">Shift Start</label>
                    <input type="time" name="working_start" id="working_start" value="{{ old('working_start') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('working_start')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="working_end" class="block text-sm font-medium text-gray-700 mb-2">Shift End</label>
                    <input type="time" name="working_end" id="working_end" value="{{ old('working_end') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    @error('working_end')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="lg:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Active dentist (can receive appointments)</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.dentists.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                    Add Dentist
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const container = document.getElementById('imagePreviewContainer');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    container.innerHTML = '<img src="' + e.target.result + '" class="w-32 h-32 rounded-xl object-cover border-2 border-gray-200">';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection