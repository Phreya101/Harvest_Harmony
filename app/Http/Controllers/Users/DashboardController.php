<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users\CategoryGroup;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $categoryGroups = CategoryGroup::with('categories')->get();

        if (Auth::user()->roles[0]->name == "admin") {
            return view('admin.dashboard', compact('categoryGroups'));
        } else if (Auth::user()->roles[0]->name == "user") {
            return view('users.dashboard', compact('categoryGroups'));
        } else {
            abort(403); // Forbidden
        }
    }
}