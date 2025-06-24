<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class scheduler extends Controller
{
    public function index()
    {
        return view('scheduler');
    }

    public function store(Request $request)
    {

        // Validate form input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'date' => 'required|date',
            'status' => 'required|string|max:10'
        ]);

        // Save to DB
        $appointment = Appointment::create([
            'name' => $validated['name'],
            'contact' => $validated['contact'],
            'date' => $validated['date'],
            'status' => $validated['status']
        ]);

        // Return AJAX response
        return response()->json([
            'status' => 'success',
            'message' => 'Appointment saved',
            'appointment' => $appointment
        ]);
    }

    public function getAppointmentCounts()
    {
        $appointments = \App\Models\Appointment::selectRaw('date, COUNT(*) as count')
            ->where('status', 'accepted')
            ->groupBy('date')
            ->get();

        $events = [];

        foreach ($appointments as $appt) {
            $events[] = [
                'title' => $appt->count >= 10 ? 'Fully Booked' : $appt->count,
                'start' => $appt->date,
                'allDay' => true,
                'display' => 'block',
                'classNames' => $appt->count >= 10 ? ['fc-full'] : ['fc-count']
            ];
        }

        return response()->json($events);
    }
}
