@extends('layouts.admin')

@section('page-title', 'Services')

@section('content')
    <div class="mb-4 md:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h2 class="text-lg font-semibold text-gray-700">
            <i class="fa-solid fa-list-check mr-2 text-blue-500"></i>{{ $services->total() }} Service(s)
        </h2>
        <a href="{{ route('admin.services.create') }}" class="bg-blue-600 text-white px-4 md:px-6 py-2 md:py-2.5 rounded-xl hover:bg-blue-700 font-medium text-sm shadow-lg shadow-blue-200 transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Add Service
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg px-4 py-3 mb-4 md:mb-6 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($services as $service)
                    <tr class="hover:bg-blue-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                                    <i class="fa-solid fa-tooth"></i>
                                </div>
                                <span class="font-semibold text-gray-900">{{ $service->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ Str::limit($service->description, 40) }}</td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-emerald-700">₱{{ number_format($service->price, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $service->duration_minutes }} min</td>
                        <td class="px-6 py-4">
                            <span class="{{ $service->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }} px-3 py-1 rounded-full text-xs font-bold">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="w-9 h-9 inline-flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 inline-flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Delete" onclick="return confirm('Are you sure you want to delete this service?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fa-solid fa-tooth text-4xl mb-2"></i>
                                <p class="font-medium">No services found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-3">
        @forelse($services as $service)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                            <i class="fa-solid fa-tooth text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $service->name }}</p>
                            <p class="text-sm text-gray-500">{{ Str::limit($service->description, 30) }}</p>
                        </div>
                    </div>
                    <span class="{{ $service->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }} px-2 py-1 rounded-full text-xs font-bold whitespace-nowrap ml-2">
                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Price</p>
                        <p class="font-bold text-emerald-700">₱{{ number_format($service->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Duration</p>
                        <p class="font-semibold text-gray-800">{{ $service->duration_minutes }} min</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.services.edit', $service->id) }}" class="flex-1 text-center bg-blue-50 text-blue-600 border border-blue-200 py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-100 transition">
                        <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-50 text-red-600 border border-red-200 py-2.5 rounded-lg font-semibold text-sm hover:bg-red-100 transition" onclick="return confirm('Are you sure you want to delete this service?')">
                            <i class="fa-solid fa-trash mr-1.5"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="text-gray-400">
                    <i class="fa-solid fa-tooth text-4xl mb-2"></i>
                    <p class="font-medium">No services found</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 md:mt-6">
        {{ $services->links() }}
    </div>
@endsection
