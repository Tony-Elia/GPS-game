<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CodesServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeamController extends Controller
{
    /**
     * Display a listing of all teams.
     */
    public function index()
    {
        // Fetch all users with the "team" role
        return view('teams');
    }

    /**
     * Create a single team with the given email and password.
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $team = User::create([
            'name' => $request->name ?? 'Team ' . uniqid(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'plain_text_password' => $request->password, // Store plain text password temporarily if needed
            'role' => 'team', // Assuming you have a "role" column in the users table
        ]);
        CodesServices::syncNewTeamCodes($team);
        return back()->with([
            'message' => 'Team created successfully!',
            'status' => 'success',
        ]);
    }
}
