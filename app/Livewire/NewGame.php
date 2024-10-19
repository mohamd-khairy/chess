<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;

class NewGame extends Component
{
    public $games = [];
    public $users = [];
    public $player1_id;
    public $player2_id;
    public $gameCreated = false;

    protected $rules = [
        'player1_id' => 'required|exists:users,id', // Assuming you have a users table
        'player2_id' => 'required|exists:users,id|different:player1_id',
    ];

    public function createGame()
    {
        $game = Game::create([
            'player1_id' => $this->player1_id,
            'player2_id' => $this->player2_id
        ]);

        // Set game created status
        $this->gameCreated = true;

        // Optionally reset the form fields
        $this->reset(['player1_id', 'player2_id']);

        $this->games = Game::where('is_finished', false)->get();
    }


    public function mount()
    {
        $this->users = \App\Models\User::all();
        $this->games = Game::where('is_finished', false)->get();
    }

    public function openGame($id)
    {
        return redirect()->route('game.show', ['gameId' => $id]);

    }

    public function render()
    {
        return view('livewire.new-game')->layout('layouts.app');
    }
}
