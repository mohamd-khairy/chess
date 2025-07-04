<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameDetail extends Model
{
    protected $fillable = [
        'game_id',
        'pawn1',
        'pawn2',
        'pawn3',
        'pawn4',
        'pawn5',
        'pawn6',
        'pawn7',
        'pawn8',
        'rook1',
        'rook2',
        'knight1',
        'knight2',
        'bishop1',
        'bishop2',
        'king',
        'queen',
        'pawn1_white',
        'pawn2_white',
        'pawn3_white',
        'pawn4_white',
        'pawn5_white',
        'pawn6_white',
        'pawn7_white',
        'pawn8_white',
        'rook1_white',
        'rook2_white',
        'knight1_white',
        'knight2_white',
        'bishop1_white',
        'bishop2_white',
        'king_white',
        'queen_white',
        'should_play'
    ];

    public function game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id', 'id');
    }

    public function shouldPlay()
    {
        return $this->belongsTo(\App\Models\User::class, 'should_play', 'id');
    }

}