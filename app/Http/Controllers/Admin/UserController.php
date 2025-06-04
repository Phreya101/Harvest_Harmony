<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Users\Feedbacks;
use Illuminate\Http\Request;
use Illuminate\View\View;


use Gate;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // denies the gate if 
        if (FacadesGate::denies('admin-access')) {
            return redirect('errors.403');
        }

        $users = User::where('id', '>=', '1'); // get only records that start with id 3 and below
        // query using model eloquent 




        return view('admin.users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //display logs of user = specific user 
        return view('admin.users.logs.show');
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'userName' => 'required|string|max:255',
            'userAddress' => 'nullable|string|max:255',
            'userNumber' => 'nullable|string|max:20',
            'userEmail' => 'required|email|max:255',
            'userPassword' => 'nullable|string|min:6',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->userName;
        $user->address = $request->userAddress;
        $user->number = $request->userNumber;
        $user->email = $request->userEmail;

        // Only update password if not empty
        if ($request->filled('userPassword')) {
            $user->password = Hash::make($request->userPassword);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }


    // new function added for viewing all user feedbacks 
    public function userfeedback()
    {
        $allfeedbacks = FacadesDB::table('feedbacks')

            ->select('*')
            ->paginate(10);

        return view('admin.users.feedbacks.show')
            ->with('allfeedbacks', $allfeedbacks);
    }

    public function getFarmers()
    {
        $farmers = User::whereHas('roles', function ($query) {
            $query->where('name', 'user'); // Assuming 'name' is the role column
        })
            ->select('id', 'name') // Select only id and name
            ->get();;

        return response()->json($farmers);
    }
}
