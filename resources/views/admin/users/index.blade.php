@extends('layouts.admin')

@section('page-title', 'Clients')

@section('content')
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
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Appointments</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                    <tr class="hover:bg-blue-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-gray-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->phone ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $user->appointments()->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-sm transition">
                                <i class="fa-solid fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fa-solid fa-users-slash text-4xl mb-2"></i>
                                <p class="font-medium">No clients found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-3">
        @forelse($users as $user)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 truncate">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                        {{ $user->appointments()->count() }} apts
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Phone</p>
                        <p class="font-semibold text-gray-800">{{ $user->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Joined</p>
                        <p class="font-semibold text-gray-800">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.users.show', $user->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg font-medium text-sm hover:bg-blue-700 transition">
                    <i class="fa-solid fa-eye mr-1"></i> View Details
                </a>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="text-gray-400">
                    <i class="fa-solid fa-users-slash text-4xl mb-2"></i>
                    <p class="font-medium">No clients found</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 md:mt-6">
        {{ $users->links() }}
    </div>
@endsection
