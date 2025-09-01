<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CodesServices
{
    public static function syncNewGameCodes(Game $game)
    {
        $teams = User::where('role', 'team')->get();
        foreach ($teams as $team) {
            $team->games()->attach($game->id, ['code' => strtoupper(bin2hex(random_bytes(3)))]);
        }
    }

    public static function syncNewTeamCodes(User $team)
    {
        $games = Game::all();
        foreach ($games as $game) {
            $team->games()->attach($game->id, ['code' => strtoupper(bin2hex(random_bytes(3)))]);
        }
    }
}
