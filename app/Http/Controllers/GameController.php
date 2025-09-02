<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Game;
use App\Models\User;
use App\Services\CodesServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index()
    {
        return Game::all();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Optional image upload
        ]);

        //handle image upload
        try {
            if ($request->hasFile('image')) {
                $imageUrl = Storage::url($request->file('image')->store('images', 'public'));
            } else {
                $imageUrl = null; // or set a default image URL
            }
        } catch (\Exception $e) {
            Log::error('Error ' . $e);
        }
        Log::info('Image URL: ' . $imageUrl);
        Log::info('Image has file: ' . $request->hasFile('image'));
        $game = Game::create([
            'name' => $request->name,
            'image_url' => $imageUrl
        ]);
        CodesServices::syncNewGameCodes($game);
        return back()->with(['message' => 'Game added successfully!', 'status' => 'success']);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user = auth()->user();
        $userGames = $user->games;
        foreach ($userGames as $game) {
            if($game->pivot->code == $request->code) {
                if($game->pivot->is_redeemed) {
                    return view('teams')->with(['message' => 'راحت عليك حد استعمله قبل كده']);
                }
                $game->pivot->is_redeemed = true;
                $game->pivot->save();
                return view('teams')->with(['game' => $game]);
            }
        }
        return view('teams')->with(['message' => 'ده مش كودك ده كود تيم تاني😏']);
    }

    public function refresh(Request $request)
    {
        Log::info('Refreshing code: ' . $request->code);
        $code = Code::query()->where('code', $request->code)->first();
        $code->is_redeemed = 0;
        Log::info('is code saved: ' . $code->save());
        return back()->with(['message' => 'Code refreshed successfully!', 'status' => 'success']);
    }
}
