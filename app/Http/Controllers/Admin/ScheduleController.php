<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        $pendingAppointments = \App\Models\Appointment::where('status', 'pending')->get();
        return view('admin.schedule.index', compact('pendingAppointments'));  // Make sure this view exists
    }

    public function saveEvent(Request $request)
    {

        // $request->merge([
        //     'start_date' => Carbon::parse($request->start_date)->setTimezone('Asia/Manila'),
        //     'end_date' => Carbon::parse($request->end_date)->setTimezone('Asia/Manila'),
        // ]);

        // Validate the incoming request
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'equipment_id' => 'required|exists:equipments,id',
            'farmer_id' => 'required|exists:users,id', // Assuming farmer is a user with a role
        ]);

        // Search for the event by its ID
        $event = Schedule::find($request->id);  // Try to find the event by ID

        if ($event) {
            // If the event exists, update it
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->equipment_id = $request->equipment_id;
            $event->farmer_id = $request->farmer_id;
            $event->save();  // Save the updated event

            // Return success response with updated event data
            return response()->json(['status' => 'success', 'event' => $event]);
        } else {
            // If the event doesn't exist, create a new event
            $event = Schedule::create([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'equipment_id' => $request->equipment_id,
                'farmer_id' => $request->farmer_id,
            ]);

            // Return success response with the newly created event data
            return response()->json(['status' => 'success', 'event' => $event]);
        }
    }



    public function getEvents()
    {
        $events = Schedule::with(['equipment', 'farmer']) // Load equipment and farmer relationships
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'start_date' => Carbon::parse($event->start_date)->setTimezone('Asia/Manila')->toDateTimeString(),  // This is assumed to be in the correct format
                    'end_date' => Carbon::parse($event->end_date)->setTimezone('Asia/Manila')->toDateTimeString(),     // This is assumed to be in the correct format
                    'equipment_id' => $event->equipment_id,
                    'equipment_name' => $event->equipment->name,  // Fetch the equipment name
                    'farmer_id' => $event->farmer_id,
                    'farmer_name' => $event->farmer->name,        // Fetch the farmer's name
                    // Add other event fields you need
                ];
            });

        return response()->json([
            "data" => $events
        ]);
    }

    public function deleteEvent($id)
    {
        $event = Schedule::find($id);

        if ($event) {
            // Delete the event from the database
            $event->delete();
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Event not found']);
        }
    }
}
