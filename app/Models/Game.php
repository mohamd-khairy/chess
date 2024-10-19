<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'player1_id',
        'player2_id',
        'is_finished',
        'winner_id',
        'last_move'
    ];

    protected $casts = [
        'last_move' => 'array'
    ];

    public function player1()
    {
        return $this->belongsTo(User::class, 'player1_id', 'id');
    }

    public function player2()
    {
        return $this->belongsTo(User::class, 'player2_id', 'id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id', 'id');
    }

    public function gameDetails()
    {
        return $this->hasOne(GameDetail::class);
    }
}
