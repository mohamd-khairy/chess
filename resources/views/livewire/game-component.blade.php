{{-- resources/views/livewire/chessboard.blade.php --}}
<div class="chessboard-container">
    <!-- Player Names and Active Player Indicator -->
    @if ($game->winner_id != null)
        <div class="text-center">
            <h3>{{ $game->winner->name }} player wins </h3>
        </div>
    @else
        <div class="player-names text-center">
            <div class="@if ($shouldPlay == $game->player1->id || $shouldPlay == null) active-player @endif">
                <h3>{{ $game->player1->name }}</h3>
            </div>
            <div class="@if ($shouldPlay == $game->player2->id) active-player @endif">
                <h3>{{ $game->player2->name }}</h3>
            </div>
        </div>
        <!-- Chessboard Display -->
        <div class="chessboard">
            @for ($row = 1; $row <= 8; $row++)
                @for ($col = 1; $col <= 8; $col++)
                    @php
                        $isWhite = ($row + $col) % 2 == 0;
                        $squareClass = $isWhite ? 'white' : 'black';
                        $pieceIcon = null;
                        $highlightClass = '';

                        // Check for a piece on the current square
                        $currentPiece = array_search([$row, $col], $pieces);

                        if ($currentPiece) {
                            $pieceIcon = "<img src='/images/{$currentPiece}.png' alt='{$currentPiece}' class='piece-icon' />";
                        }

                        // Highlight the last move
                        if ($lastMove == [$row, $col]) {
                            $highlightClass = 'yellow';
                        }

                        // Highlight the selected square
                        if ($selectedSquare == [$row, $col]) {
                            $highlightClass = 'selected';
                        }
                    @endphp

                    <!-- Render the square with the piece (if present) -->
                    <div class="square {{ $squareClass }} {{ $highlightClass }}"
                        wire:click="moveToSquare({{ $row }}, {{ $col }})">
                        {!! $pieceIcon !!}
                    </div>
                @endfor
            @endfor
        </div>
    @endif
    <!-- Auto-refresh data every 5 seconds -->
    <div x-init="setInterval(() => $wire.refreshData(), 5000)">
    </div>
</div>
