<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role != 'admin') {
            return to_route('teams.index');
        }

        $games = \App\Models\Game::all();
        $teams = \App\Models\User::where('role', 'team')->get();

        // Build fixed 2D array: codes[team_id][game_id]
        $codesMatrix = [];

        foreach ($teams as $team) {
            $row = [];

            foreach ($games as $game) {
                // Check if code exists for this team+game
                $code = DB::table('codes')->where('user_id', '=', $team->id)
                    ->where('game_id', '=', $game->id)
                    ->first();
                $row[$game->id] = $code ? $code->code : ''; // empty if missing
            }

            $codesMatrix[$team->id]['codes'] = $row;
            $codesMatrix[$team->id]['team'] = $team->name;
        }

        return view('dashboard')->with([
            'games'  => $games,
            'teams'  => $teams,
            'codes'  => $codesMatrix, // <-- fixed 2D structure
        ]);
    }

}
