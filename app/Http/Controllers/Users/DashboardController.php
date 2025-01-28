<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
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


        if (Auth::user()->roles[0]->name == "admin") {
            return view('admin.dashboard');
        } else if (Auth::user()->roles[0]->name == "user") {
            return view('users.dashboard', compact('categoryGroups', 'threads'));
        } else {
            abort(403); // Forbidden
        }
    }
}
