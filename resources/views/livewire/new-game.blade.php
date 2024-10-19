{{-- resources/views/livewire/new-game.blade.php --}}
<div class="new-game-container">
    <h2 class="text-2xl font-bold mb-4">Create New Game</h2>

    @if ($gameCreated)
        <div class="bg-green-500 p-2 mb-4" style="color: green">
            Game created successfully!
        </div>
    @endif

    <form wire:submit.prevent="createGame">
        <div class="mb-4">
            <label for="player1" class="block text-sm font-medium text-gray-700">Player 1:</label>
            <select wire:model="player1_id" id="player1" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="">Select Player 1</option>
                @foreach ($users as $user)
                    {{-- Assuming you have a users array passed to the view --}}
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('player1_id')
                <span class="text-red text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="player2" class="block text-sm font-medium text-gray-700">Player 2:</label>
            <select wire:model="player2_id" id="player2"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="">Select Player 2</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('player2_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 p-2 rounded">Start Game</button>
    </form>


    @if ($games->count() > 0)
        <div class="mt-4">
            <h3 class="text-lg font-bold mb-2">Previous Games</h3>
            <ul class="list-disc list-inside">
                @foreach ($games as $game)
                    <li>
                        <a href="#" wire:click.prevent="openGame({{ $game->id }})" class="text-blue-500 hover:text-blue-700">
                            {{ $game->player1->name }} vs {{ $game->player2->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    @endif
</div>
