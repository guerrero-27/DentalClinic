<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DentistController extends Controller
{
    public function index()
    {
        $dentists = User::where('role', 'dentist')->latest()->paginate(12);
        return view('admin.dentists.index', compact('dentists'));
    }

    public function create()
    {
        return view('admin.dentists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'working_start' => 'nullable|date_format:H:i',
            'working_end' => 'nullable|date_format:H:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('dentists', 'public');
        }

        $validated['password'] = bcrypt('password123');
        $validated['role'] = 'dentist';

        User::create($validated);

        return redirect()->route('admin.dentists.index')->with('success', 'Dentist added successfully');
    }

    public function show(User $dentist)
    {
        if (!$dentist->isDentist()) {
            abort(404);
        }
        $appointments = $dentist->appointments()->with('service')->latest()->paginate(10);
        return view('admin.dentists.show', compact('dentist', 'appointments'));
    }

    public function edit(User $dentist)
    {
        if (!$dentist->isDentist()) {
            abort(404);
        }
        return view('admin.dentists.edit', compact('dentist'));
    }

    public function update(Request $request, User $dentist)
    {
        if (!$dentist->isDentist()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $dentist->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'working_start' => 'nullable|date_format:H:i',
            'working_end' => 'nullable|date_format:H:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($dentist->image) {
                \Storage::disk('public')->delete($dentist->image);
            }
            $validated['image'] = $request->file('image')->store('dentists', 'public');
        }

        $dentist->update($validated);

        return redirect()->route('admin.dentists.index')->with('success', 'Dentist updated successfully');
    }

    public function destroy(User $dentist)
    {
        if (!$dentist->isDentist()) {
            abort(404);
        }

        if ($dentist->image) {
            \Storage::disk('public')->delete($dentist->image);
        }

        $dentist->delete();

        return redirect()->route('admin.dentists.index')->with('success', 'Dentist removed successfully');
    }
}