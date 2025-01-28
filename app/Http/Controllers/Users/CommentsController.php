<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\users\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function store(Request $request)
    {

        // Validate the incoming data
        $validated = $request->validate([
            'comment' => 'required|string',
            'thread_id' => 'required|integer',
            'farmers_id' => 'required|integer',
        ]);

        // Create the thread with validated data
        try {
            // Create the thread with validated data
            Comment::create([
                'comment' => $validated['comment'],
                'thread_id' => $validated['thread_id'],
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
            'comment' => 'required|string|max:255',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->comment = $request->comment;
        $comment->save();



        return response()->json(['status' => 'success', 'message' => 'Comment updated successfully!']);
    }

    public function delete($id)
    {
        try {
            $comment = Comment::findOrFail($id); // Find the comment by ID
            $comment->delete(); // Delete the comment

            return response()->json(['status' => 'success', 'message' => 'Comment deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete comment.']);
        }
    }
}
