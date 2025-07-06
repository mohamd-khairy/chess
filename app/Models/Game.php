<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'player1_id',
        'player2_id',
        'winner_id',
        'is_finished',
        'last_move'
    ];

    protected $casts = [
        'is_finished' => 'boolean'
    ];

    public function player1()
    {
        return $this->belongsTo(\App\Models\User::class, 'player1_id', 'id');
    }

    public function player2()
    {
        return $this->belongsTo(\App\Models\User::class, 'player2_id', 'id');
    }

    public function winner()
    {
        return $this->belongsTo(\App\Models\User::class, 'winner_id', 'id');
    }

    public function gameDetails()
    {
        return $this->hasMany(GameDetail::class);
    }

}