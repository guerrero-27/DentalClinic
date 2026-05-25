@extends('layouts.admin')

@section('page-title', 'Dentists')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <p class="text-gray-600">Manage dental professionals</p>
        <a href="{{ route('admin.dentists.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 md:px-6 py-2 md:py-2.5 rounded-xl hover:bg-blue-700 font-medium text-sm shadow-lg shadow-blue-200 transition">
            <i class="fa-solid fa-plus"></i>
            Add Dentist
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg px-4 py-3 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($dentists->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($dentists as $dentist)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <!-- Profile Section -->
                    <div class="p-6 text-center border-b border-gray-100">
                        @if($dentist->image)
                            <img src="{{ asset('storage/' . $dentist->image) }}" alt="{{ $dentist->name }}" class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-2 border-gray-200">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-200 mx-auto mb-4 flex items-center justify-center text-gray-500 text-3xl font-bold border-2 border-gray-300">
                                {{ strtoupper(substr($dentist->name, 0, 1)) }}
                            </div>
                        @endif
                        <h3 class="font-bold text-gray-900 text-lg">{{ $dentist->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $dentist->email }}</p>
                    </div>

                    <!-- Info Section -->
                    <div class="p-4 space-y-3">
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fa-solid fa-phone text-gray-400 w-5"></i>
                            <span class="text-gray-600">{{ $dentist->phone ?? 'Not set' }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fa-solid fa-calendar text-gray-400 w-5"></i>
                            <span class="text-gray-600">
                                @if($dentist->working_start && $dentist->working_end)
                                    {{ \Carbon\Carbon::parse($dentist->working_start)->format('g:i A') }} - {{ \Carbon\Carbon::parse($dentist->working_end)->format('g:i A') }}
                                @else
                                    Not scheduled
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fa-solid fa-user-injured text-gray-400 w-5"></i>
                            <span class="text-gray-600">{{ $dentist->appointments()->where('status', 'confirmed')->count() }} appointments</span>
                        </div>
                    </div>

                    <!-- Status & Actions -->
                    <div class="px-4 pb-4 pt-2 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $dentist->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dentist->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                {{ $dentist->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.dentists.edit', $dentist->id) }}" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('admin.dentists.show', $dentist->id) }}" class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button type="button" onclick="showDeleteModal({{ $dentist->id }}, '{{ addslashes($dentist->name) }}', {{ $dentist->appointments()->where('status', 'confirmed')->count() }})" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $dentists->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <div class="text-gray-400">
                <i class="fa-solid fa-user-doctor text-5xl mb-4"></i>
                <p class="text-lg font-medium text-gray-600 mb-2">No dentists yet</p>
                <p class="text-gray-500 mb-6">Start by adding your first dental professional</p>
                <a href="{{ route('admin.dentists.create') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-gray-800 transition">
                    <i class="fa-solid fa-plus"></i>
                    Add Dentist
                </a>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <div class="text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 mx-auto mb-4 flex items-center justify-center">
                    <i class="fa-solid fa-trash text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Dentist</h3>
                <p class="text-gray-500 mb-6">Are you sure you want to delete <span id="dentistName" class="font-medium text-gray-900"></span>? This action cannot be undone.</p>
                <div class="flex gap-3">
                    <button onclick="hideDeleteModal()" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cannot Delete Modal -->
    <div id="cannotDeleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <div class="text-center">
                <div class="w-12 h-12 rounded-full bg-yellow-100 mx-auto mb-4 flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation text-yellow-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Cannot Delete Dentist</h3>
                <p class="text-gray-500 mb-6"><span id="cannotDeleteName" class="font-medium text-gray-900"></span> still has <span id="appointmentCount" class="font-medium text-gray-900"></span>. Please remove or reassign appointments first.</p>
                <button onclick="hideCannotDeleteModal()" class="w-full px-4 py-2.5 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition">
                    OK
                </button>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(id, name, appointmentCount) {
            if (appointmentCount > 0) {
                document.getElementById('cannotDeleteName').textContent = name;
                document.getElementById('appointmentCount').textContent = appointmentCount + ' appointment' + (appointmentCount > 1 ? 's' : '');
                document.getElementById('cannotDeleteModal').classList.remove('hidden');
                document.getElementById('cannotDeleteModal').classList.add('flex');
            } else {
                document.getElementById('dentistName').textContent = name;
                document.getElementById('deleteForm').action = '/admin/dentists/' + id;
                document.getElementById('deleteModal').classList.remove('hidden');
                document.getElementById('deleteModal').classList.add('flex');
            }
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        function hideCannotDeleteModal() {
            document.getElementById('cannotDeleteModal').classList.add('hidden');
            document.getElementById('cannotDeleteModal').classList.remove('flex');
        }
    </script>
@endsection