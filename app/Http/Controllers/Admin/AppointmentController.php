<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['user', 'service'])->latest();

        if ($request->filled('status')){
            $query->where('status', $request->status);
        }

        if ($request->filled('date')){
            $query->whereDate('appointment_date', $request->date);
        }

        if ($request->filled('search')){
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search. '%')
                ->orWhere('email', 'like', '%'.$request->search.'%')
            );
        }

        $appointments = $query->paginate(15);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'service']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $appointment->update($validated);

        return back()->with('success', 'Appointment Status Updated Successfully.');
    }
}
