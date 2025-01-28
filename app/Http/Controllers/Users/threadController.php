<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\CategoryGroup;
use App\Models\users\Comment;
use App\Models\users\Replies;
use Illuminate\Http\Request;
use App\Models\Users\Thread;



class ThreadController extends Controller
{
    public function index($id)
    {
        $comments = Comment::with(['user', 'replies'])
            ->where('thread_id', $id) // Get only comments for the specific thread
            ->orderBy('created_at', 'desc') // Show latest comments first
            ->get();
        $categoryGroups = CategoryGroup::with('categories')->get();
        $thread = Thread::with(['user', 'category.categoryGroup', 'comment'])->find($id);
        return view('users.thread', compact('thread', 'categoryGroups', 'comments'));
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|integer|exists:category,id',
        ]);

        $thread = Thread::findOrFail($id);
        $thread->title = $request->title;
        $thread->category_id = $request->category;
        $thread->save();



        return response()->json(['status' => 'success', 'message' => 'Thread updated successfully!']);
    }

    public function delete($id)
    {
        try {
            $thread = Thread::findOrFail($id); // Find the thread by ID
            $thread->delete(); // Delete the thread

            return response()->json(['status' => 'success', 'message' => 'Thread deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete thread.']);
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        // Filter threads based on the query
        $threads = Thread::with('category', 'user', 'comment')
            ->where('title', 'like', '%' . $query . '%')
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->withCount('comment')
            ->get();

        // Return the filtered threads as JSON
        return response()->json([
            'threads' => $threads->map(function ($thread) {
                return [
                    'id' => $thread->id,
                    'category' => $thread->category,
                    'title' => $thread->title,
                    'created_at' => $thread->created_at->format('F d, Y'),
                    'user' => $thread->user,
                    'comment_count' => $thread->comment->count()
                ];
            })
        ]);
    }
}
