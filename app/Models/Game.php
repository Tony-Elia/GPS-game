<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    protected $guarded = [];

    public function teams()
    {
        return $this->belongsToMany(User::class, 'codes', 'user_id', 'game_id')
            ->withPivot('code', 'is_redeemed');
    }
}
