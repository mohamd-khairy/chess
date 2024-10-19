<?php

function move($selectedSquare, $newSquare, $key, $pieces)
{
    // Extract the piece type and color from the key
    $isWhite = strpos($key, 'white') !== false;
    $color = $isWhite ? 'white' : 'black';

    // Map each piece key prefix to the corresponding move function
    $pieceType = getPieceType($key);

    return match ($pieceType) {
        'rook' => moveRook($selectedSquare, $newSquare, $key, $pieces, $color),
        'knight' => moveKnight($selectedSquare, $newSquare, $key, $pieces, $color),
        'bishop' => moveBishop($selectedSquare, $newSquare, $key, $pieces, $color),
        'queen' => moveQueen($selectedSquare, $newSquare, $key, $pieces, $color),
        'king' => moveKing($selectedSquare, $newSquare, $key, $pieces, $color),
        'pawn' => movePawn($selectedSquare, $newSquare, $key, $pieces, $color),
        default => false, // Handle invalid piece types
    };
}

// Helper function to get the piece type from the key
function getPieceType($key)
{
    if (str_starts_with($key, 'rook')) {
        return 'rook';
    } elseif (str_starts_with($key, 'knight')) {
        return 'knight';
    } elseif (str_starts_with($key, 'bishop')) {
        return 'bishop';
    } elseif (str_starts_with($key, 'queen')) {
        return 'queen';
    } elseif (str_starts_with($key, 'king')) {
        return 'king';
    } elseif (str_starts_with($key, 'pawn')) {
        return 'pawn';
    }

    return null; // In case of invalid piece type
}

function isKingInCheck($kingColor, $playerPieces,  $pieces)
{
    $kingPosition = getKingPosition($kingColor, $pieces);

    // dd($kingPosition);
    if ($kingPosition) {
        // Loop through all opponent pieces and see if any can move to the king's position
        foreach ($playerPieces as $key => $position) {
            if ($position && move($position, $kingPosition, $key, $pieces)) {
                return true; // King is in check
            }
        }
    }
    return false; // King is safe
}

function getKingPosition($kingColor, $pieces)
{
    $kingKey = $kingColor == 'black' ? 'king' : 'king_white';
    $kingPosition = $pieces[$kingKey];
    return $kingPosition;
}

function canEscapeCheck($pieces)
{
    // Loop through all pieces of the current player
    foreach ($pieces as $key => $position) {
        // Try moving the piece to all possible squares (within board bounds)
        for ($row = 1; $row <= 8; $row++) {
            for ($col = 1; $col <= 8; $col++) {
                $newSquare = [$row, $col];
                if ($position && move($position, $newSquare, $key, $pieces)) {
                    return true; // Found a valid move to escape check
                }
            }
        }
    }


    return false; // No valid move to escape check
}


function moveKnight($selectedSquare, $newSquare, $key,  $pieces, $knightColor): bool
{
    // Calculate row and column differences
    $rowDiff = abs($newSquare[0] - $selectedSquare[0]);
    $colDiff = abs($newSquare[1] - $selectedSquare[1]);

    // Check if the move follows an "L" shape (2 squares in one direction and 1 square in the other)
    if (!(($rowDiff == 2 && $colDiff == 1) || ($rowDiff == 1 && $colDiff == 2))) {
        return false; // Invalid move
    }

    // Check if the destination square contains a piece
    $newMovekey = array_search($newSquare, $pieces);

    if ($newMovekey) {

        $newPieceColor = strpos($newMovekey, 'white') !== false ? 'white' : 'black';
        if ($newPieceColor == $knightColor) {
            return false;
        }
    }

    return true; // Valid move
}


function moveQueen($selectedSquare, $newSquare, $key, $pieces, $queenColor): bool
{
    $rowDiff = abs($newSquare[0] - $selectedSquare[0]);
    $colDiff = abs($newSquare[1] - $selectedSquare[1]);

    // Check if it's a valid rook-like move (same row or same column)
    if ($selectedSquare[0] == $newSquare[0] || $selectedSquare[1] == $newSquare[1]) {
        return moveRook($selectedSquare, $newSquare, $key, $pieces, $queenColor);
    }

    // Check if it's a valid bishop-like move (diagonal)
    if ($rowDiff == $colDiff) {
        return moveBishop($selectedSquare, $newSquare, $key, $pieces, $queenColor);
    }

    // If neither rook nor bishop move, it's an invalid queen move
    return false;
}



function moveKing($selectedSquare, $newSquare, $key, $pieces, $kingColor): bool
{
    // Calculate the row and column differences
    $rowDiff = abs($newSquare[0] - $selectedSquare[0]);
    $colDiff = abs($newSquare[1] - $selectedSquare[1]);

    // Ensure the king moves only one square in any direction (horizontal, vertical, or diagonal)
    if ($rowDiff > 1 || $colDiff > 1) {
        return false;
    }

    // Check if the destination square has a piece
    $newMovekey = array_search($newSquare, $pieces);

    if ($newMovekey) {
        // If there is a piece, check if it's an opponent's piece
        $newPieceColor = strpos($newMovekey, 'white') !== false ? 'white' : 'black';
        if ($newPieceColor == $kingColor) {
            return false;
        }
    }

    return true; // Valid move
}


function moveBishop($selectedSquare, $newSquare, $key, $pieces, $bishopColor): bool
{
    $rowDiff = abs($newSquare[0] - $selectedSquare[0]);
    $colDiff = abs($newSquare[1] - $selectedSquare[1]);

    // Bishops move diagonally, so row and column difference must be equal
    if ($rowDiff != $colDiff) {
        return false;
    }

    // Determine the direction of movement (up-right, down-right, up-left, down-left)
    $rowDirection = ($newSquare[0] > $selectedSquare[0]) ? 1 : -1;
    $colDirection = ($newSquare[1] > $selectedSquare[1]) ? 1 : -1;

    // Check all squares along the diagonal path for obstruction
    for ($i = 1; $i < $rowDiff; $i++) {
        $checkSquare = [$selectedSquare[0] + $i * $rowDirection, $selectedSquare[1] + $i * $colDirection];
        if (array_search($checkSquare, $pieces)) {
            return false; // Obstruction found
        }
    }

    // Check the destination square
    $newMovekey = array_search($newSquare, $pieces);

    if ($newMovekey) {

        $newPieceColor = strpos($newMovekey, 'white') !== false ? 'white' : 'black';

        if ($newPieceColor == $bishopColor) {
            return false;
        }
    }

    return true; // Valid move
}


function moveRook($selectedSquare, $newSquare, $key, $pieces, $currentColor): bool
{
    // Check for vertical (column) movement
    if ($newSquare[1] == $selectedSquare[1] && $newSquare[0] != $selectedSquare[0]) {
        return checkPathForRook($selectedSquare, $newSquare, $pieces, true, $currentColor);
    }

    // Check for horizontal (row) movement
    if ($newSquare[0] == $selectedSquare[0] && $newSquare[1] != $selectedSquare[1]) {
        return checkPathForRook($selectedSquare, $newSquare, $pieces, false, $currentColor);
    }

    // Invalid move (not in a straight line)
    return false;
}

/**
 * Helper function to check the path for the rook's movement (for both black and white)
 *
 * @param array $selectedSquare The current position of the rook
 * @param array $newSquare The new position to move the rook to
 * @param array $pieces The current game pieces on the board
 * @param bool $isVertical Whether the movement is vertical (true) or horizontal (false)
 * @param string $currentColor The color of the current player's rook ('black' or 'white')
 * @return bool Whether the move is valid
 */
function checkPathForRook($selectedSquare, $newSquare, $pieces, $isVertical, $currentColor): bool
{
    $diff = $isVertical ? abs($newSquare[0] - $selectedSquare[0]) : abs($newSquare[1] - $selectedSquare[1]);
    $stepDirection = ($isVertical ? $newSquare[0] - $selectedSquare[0] : $newSquare[1] - $selectedSquare[1]) > 0 ? 1 : -1;

    for ($i = 1; $i <= $diff; $i++) {
        $checkSquare = $isVertical
            ? [$selectedSquare[0] + $i * $stepDirection, $selectedSquare[1]]
            : [$selectedSquare[0], $selectedSquare[1] + $i * $stepDirection];

        $newMovekey = array_search($checkSquare, $pieces);

        if ($newMovekey) {
            // Determine the piece color on the new square
            $newPieceColor = strpos($newMovekey, 'white') !== false ? 'white' : 'black';

            // Valid if the piece at the new square is of the opposite color (i.e., capturing an opponent)
            if ($checkSquare == $newSquare && $newPieceColor != $currentColor) {
                return true;
            }
            return false; // Blocked by a piece
        }
    }

    return true;
}

function movePawn($selectedSquare, $newSquare, $key, $pieces, $pawnColor): bool
{
    $rowDiff = ($newSquare[0] - $selectedSquare[0]);
    $colDiff = ($newSquare[1] - $selectedSquare[1]);
    $newMovekey = array_search($newSquare, $pieces);

    // Set movement direction based on pawn color (black moves down, white moves up)
    $moveDirection = ($pawnColor == 'black') ? 1 : -1;

    // Standard move: move forward by 1 square in the correct direction
    if ($rowDiff == $moveDirection && $colDiff == 0 && !$newMovekey) {
        return true;
    }

    // Capture move: diagonal move by 1 square, only if there is an opponent's piece
    if ($rowDiff == $moveDirection && abs($colDiff) == 1 && $newMovekey) {

        $newPieceColor = strpos($newMovekey, 'white') !== false ? 'white' : 'black';

        // Valid if the piece at the new square is of the opposite color (i.e., capturing an opponent)
        if ($newPieceColor != $pawnColor) {
            return true;
        }
    }

    // Two-square advance on the first move for white pawns
    if ($pawnColor == 'white' && $selectedSquare[0] == 7 && $rowDiff == -2 && $colDiff == 0) {
        // Check if the square between the selected square and the new square is empty
        $intermediateSquare = [6, $selectedSquare[1]];
        if (!array_search($intermediateSquare, $pieces) && !$newMovekey) {
            return true;
        }
    }

    // Two-square advance on the first move for black pawns
    if ($pawnColor == 'black' && $selectedSquare[0] == 2 && $rowDiff == 2 && $colDiff == 0) {
        // Check if the square between the selected square and the new square is empty
        $intermediateSquare = [3, $selectedSquare[1]];
        if (!array_search($intermediateSquare, $pieces) && !$newMovekey) {
            return true;
        }
    }

    return false;
}
