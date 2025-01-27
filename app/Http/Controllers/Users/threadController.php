<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users\Thread;



class ThreadController extends Controller
{
    public function index()
    {
        return view('users.thread');
    }

    public function store(Request $request)
    {

        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string',
            'category' => 'required|integer',
            'farmers_id' => 'required|integer',
        ]);

        // Create the thread with validated data
        try {
            // Create the thread with validated data
            Thread::create([
                'title' => $validated['title'],
                'category_id' => $validated['category'],
                'farmers_id' => $validated['farmers_id'],
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
