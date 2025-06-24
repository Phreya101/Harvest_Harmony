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

    public function getAppointmentList()
    {
        $appointments = \App\Models\Appointment::where('status', 'accepted')->get();

        $events = [];

        foreach ($appointments as $appt) {
            $events[] = [
                'id'    => $appt->id,              // handy for eventClick / editing
                'title' => $appt->name,            // NAME shows up on the calendar
                'start' => $appt->date,            // adjust if you store a datetime
                'allDay' => true,                  // true if you don’t store time
                // send extra data down in extendedProps
                'extendedProps' => [
                    'contact' => $appt->contact,
                    'status'  => $appt->status,
                ],
                // optional class if you still want per-event styling
                'classNames' => ['fc-booking'],
            ];
        }

        return response()->json($events);
    }

    public function accept($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'accepted';
        $appointment->save();

        return back()->with('success', 'Appointment accepted!');
    }

    public function reject($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'rejected';
        $appointment->save();

        return back()->with('success', 'Appointment rejected!');
    }
}
