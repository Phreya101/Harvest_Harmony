<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Users\CategoryGroup;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\Thread;

class DashboardController extends Controller
{
    public function index()
    {
        $categoryGroups = CategoryGroup::with('categories')->get();

        $threads = Thread::with(['user', 'category.categoryGroup'])->latest()->get();

        $users = User::all();


        if (Auth::user()->roles[0]->name == "admin") {
            return view('admin.dashboard', compact('users', 'threads', 'categoryGroups'));
        } else if (Auth::user()->roles[0]->name == "user") {
            return view('users.dashboard', compact('categoryGroups', 'threads'));
        } else {
            abort(403); // Forbidden
        }
    }

    public function delete_thread($id)
    {
        try {
            $thread = Thread::findOrFail($id); // Find the thread by ID
            $thread->delete(); // Delete the thread

            return response()->json(['status' => 'success', 'message' => 'Thread deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete thread.']);
        }
    }
}
