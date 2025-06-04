<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\dashboard;
use Illuminate\Http\Request;

class dashboardController extends Controller
{

    // Display a listing of posts
    public function index($threads) {}


    // Remove the specified post from storage
    public function destroy(dashboard $thread)
    {
        $thread->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Post deleted successfully.');
    }
}
