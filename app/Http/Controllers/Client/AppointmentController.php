<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = auth()->user()->appointments()->with('service')->latest()->paginate(10);
        
        return view('client.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->get();
        return view('client.appointments.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'notes' => 'nullable||string|max:500',
        ]);

        $conflict = Appointment::where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->whereNotIn('status', ['cancelled'])->exists();

        if($conflict){
            return back()->withErrors(['appointment_time' => 'This time slot is already booked. Please choose another.'])->withInput();
        }

        auth()->user()->appointments()->create($validated);

        return redirect()->route('client.appointment.index')->with('success', 'Appointment Booked Successfully! We will confirm shortly.');
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        return view('client.appointments.show', compact('appointment'));
    }

    puublic function cancel(Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        if (!in_array($appointment->status, ['pending', 'confirmed'])){
            return back()->with('error', 'This appointment cannot be Cancelled.');
        }
        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Appointment Cancelled Successfully.');
    }
}
