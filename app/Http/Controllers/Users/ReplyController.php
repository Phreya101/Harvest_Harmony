<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\users\Replies;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request)
    {

        // Validate the incoming data
        $validated = $request->validate([
            'reply' => 'required|string',
            'comment_id' => 'required|integer',
            'farmers_id' => 'required|integer',
        ]);

        // Create the thread with validated data
        try {
            // Create the thread with validated data
            Replies::create([
                'reply' => $validated['reply'],
                'comment_id' => $validated['comment_id'],
                'farmers_id' => $validated['farmers_id'],
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:255',
        ]);

        $reply = Replies::findOrFail($id);
        $reply->reply = $request->reply;
        $reply->save();



        return response()->json(['status' => 'success', 'message' => 'Reply updated successfully!']);
    }

    public function delete($id)
    {
        try {
            $reply = Replies::findOrFail($id); // Find the comment by ID
            $reply->delete(); // Delete the comment

            return response()->json(['status' => 'success', 'message' => 'Reply deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete reply.']);
        }
    }
}
