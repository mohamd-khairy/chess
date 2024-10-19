<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\GameDetail;
use Livewire\Component;

class GameComponent extends Component
{
    const BOARD_SIZE = 8;
    public $selectedSquare = null;
    public $lastMove = null;
    public $game = null;
    public $gameEnded = null;
    public $gameDetails = null;
    public $shouldPlay = null;
    public $player1 = null;
    public $player2 = null;
    public $pieces = [];
    public $player1Pieces = [
        'rook1',
        'knight1',
        'bishop1',
        'queen',
        'king',
        'bishop2',
        'knight2',
        'rook2'
    ];
    public $player2Pieces = [
        'rook1_white',
        'knight1_white',
        'bishop1_white',
        'queen_white',
        'king_white',
        'bishop2_white',
        'knight2_white',
        'rook2_white'
    ];

    public function mount($gameId)
    {
        $this->game = Game::with('player1', 'player2', 'gameDetails')
            ->findOrFail($gameId ?? $this->game->id);
        $this->player1 = $this->game->player1;
        $this->player2 = $this->game->player2;

        if (!$this->gameDetails) {
            $this->initializePieces();
        }

        $this->refreshData($gameId);
    }

    public function refreshData($gameId = null)
    {
        $this->lastMove = $this->game->last_move;
        $this->gameDetails = GameDetail::where('game_id', $this->game->id)->first();
        $this->pieces =  $this->gameDetails ? $this->gameDetails->toArray() : $this->pieces;
        $this->shouldPlay = $this->gameDetails ? $this->gameDetails->should_play : $this->game->player1->id;
    }

    private function initializePieces()
    {
        $this->pieces = array_merge(
            array_combine($this->player1Pieces, [[1, 1], [1, 2], [1, 3], [1, 4], [1, 5], [1, 6], [1, 7], [1, 8]]),
            array_combine($this->player2Pieces, [[8, 1], [8, 2], [8, 3], [8, 4], [8, 5], [8, 6], [8, 7], [8, 8]])
        );

        $this->addPawns();
    }

    private function addPawns()
    {
        for ($col = 1; $col <= self::BOARD_SIZE; $col++) {
            $this->pieces["pawn{$col}"] = [2, $col];
            $this->pieces["pawn{$col}_white"] = [7, $col];
            $this->player1Pieces[] = "pawn{$col}";
            $this->player2Pieces[] = "pawn{$col}_white";
        }
    }


    public function selectSquare($row, $col)
    {
        if ($this->isCurrentPlayerTurn()) {
            $currentPlayerPieces = $this->getCurrentPlayerPieces();
            if ($this->isPieceBelongsToPlayer([$row, $col], $currentPlayerPieces)) {
                $myColor = $this->getCurrentPlayerColor();
                $otherColor = $this->getOtherPlayerColor();
// dd(isKingInCheck($otherColor, $this->getPiecesByColor($myColor), $this->pieces));
                if (isKingInCheck($myColor, $this->getPiecesByColor($otherColor), $this->pieces)) {
                    $this->selectedSquare = getKingPosition($myColor, $this->pieces);
                } else {
                    $this->selectedSquare = [$row, $col];
                }
            }
        }

    }

    public function moveToSquare($row, $col)
    {
        $this->selectSquare($row, $col);

        if (!$this->selectedSquare || $this->selectedSquare == [$row, $col]) {
            return;
        }

        $key = $this->getKeyByPosition($this->selectedSquare);

        $myColor = $this->getCurrentPlayerColor();
        $otherColor = $this->getOtherPlayerColor();

        if (
            $this->moveIsValid($this->selectedSquare, [$row, $col], $key)
            && !isKingInCheck($myColor, $this->getPiecesByColor($otherColor), $this->pieces)
            && canEscapeCheck($this->getPiecesByColor($otherColor))
        ) {
            $this->updatePiecePosition($key, [$row, $col]);
            $this->switchPlayer();
            $this->syncPieces();
            $this->selectedSquare = null;
        }else{
            $this->endGame("Checkmate! {$otherColor} wins!");
        }
    }

    public function endGame($message)
    {
        $this->game->update(['winner_id' => $this->getOtherPlayerId(), 'is_finished' => true ]);
        $this->gameEnded = $message;
    }

    public function getPiecesByColor($color)
    {
        if ($color == 'white') {
            $playerPieces = $this->player2Pieces;
        } else {
            $playerPieces = $this->player1Pieces;
        }
        return $selectedPieces = array_intersect_key($this->pieces, array_flip($playerPieces));
    }

    private function moveIsValid($from, $to, $key)
    {
        return move($from, $to, $key, $this->pieces);
    }

    private function updatePiecePosition($key, $position)
    {
        if ($targetKey = $this->getKeyByPosition($position)) {
            $this->pieces[$targetKey] = null; // Capture the opponent's piece
        }
        $this->pieces[$key] = $position;
        $this->selectedSquare = null;
        $this->lastMove = $position;
    }

    public function syncPieces()
    {
        $this->game->update(['last_move' => $this->lastMove]);

        $data = ['should_play' => $this->shouldPlay, 'game_id' => $this->game->id] + $this->pieces;

        $this->gameDetails ? $this->gameDetails->update($data) : $this->gameDetails = GameDetail::create($data);
    }

    public function switchPlayer()
    {
        $this->shouldPlay = $this->shouldPlay === $this->player1->id ? $this->player2->id : $this->player1->id;
    }

    public function getCurrentPlayerColor()
    {
        return auth()->user()->id === $this->player1->id ? 'black' : 'white';
    }

    public function getOtherPlayerColor()
    {
        return $this->getCurrentPlayerColor() == 'white' ? 'black' : 'white';
    }

    public function getCurrentPlayerPieces()
    {
        return $this->shouldPlay === $this->player1->id ? $this->player1Pieces : $this->player2Pieces;
    }

    public function getLoginPlayerPieces()
    {
        return auth()->user()->id === $this->player1->id ? $this->player1Pieces : $this->player2Pieces;
    }

    private function isCurrentPlayerTurn()
    {
        return $this->shouldPlay === auth()->user()->id;
    }

    private function getCurrentPlayerId()
    {
        return auth()->user()->id;
    }

    private function getOtherPlayerId()
    {
        return $this->shouldPlay === $this->player1->id ? $this->player2->id : $this->player1->id;
    }

    private function isPieceBelongsToPlayer($position, $playerPieces)
    {
        return in_array($this->getKeyByPosition($position), $playerPieces);
    }

    public function getKeyByPosition($position)
    {
        return array_search($position, $this->pieces);
    }

    public function render()
    {
        return view('livewire.game-component', ['pieces' => $this->pieces])
            ->layout('layouts.app');
    }
}
