<?php

use App\Livewire\GameComponent;
use App\Livewire\NewGame;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', NewGame::class)->name('new-game');
Route::get('/game/{gameId}', GameComponent::class)->name('game.show');

Auth::routes();

