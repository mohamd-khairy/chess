<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameDetail extends Model
{
    protected $fillable = [
        'game_id',
        'player_id',

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

        'bishop1',
        'bishop2',

        'knight1',
        'knight2',

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

        'bishop1_white',
        'bishop2_white',

        'knight1_white',
        'knight2_white',

        'king_white',
        'queen_white',

        'should_play'
    ];

    protected $casts = [
        'pawn1' => 'array',
        'pawn2' => 'array',
        'pawn3' => 'array',
        'pawn4' => 'array',
        'pawn5' => 'array',
        'pawn6' => 'array',
        'pawn7' => 'array',
        'pawn8' => 'array',
        'rook1' => 'array',
        'rook2' => 'array',
        'bishop1' => 'array',
        'bishop2' => 'array',
        'knight1' => 'array',
        'knight2' => 'array',
        'king' => 'array',
        'queen' => 'array',

        'pawn1_white' => 'array',
        'pawn2_white' => 'array',
        'pawn3_white' => 'array',
        'pawn4_white' => 'array',
        'pawn5_white' => 'array',
        'pawn6_white' => 'array',
        'pawn7_white' => 'array',
        'pawn8_white' => 'array',
        'rook1_white' => 'array',
        'rook2_white' => 'array',
        'bishop1_white' => 'array',
        'bishop2_white' => 'array',
        'knight1_white' => 'array',
        'knight2_white' => 'array',
        'king_white' => 'array',
        'queen_white' => 'array',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($model) {
    //         sse_notify($model);
    //     });

    //     static::updated(function ($model) {
    //         sse_notify($model);
    //     });
    // }
}
