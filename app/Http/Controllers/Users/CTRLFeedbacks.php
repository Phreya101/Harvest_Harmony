<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CTRLFeedbacks extends Controller
{
    // Example method
    public function index()
    {
        return view('feedbacks.index');
    }
}