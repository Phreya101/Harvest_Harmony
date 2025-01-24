<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class threadController extends Controller
{
    public function viewThread()
    {
        return view('users.thread');
    }
}
