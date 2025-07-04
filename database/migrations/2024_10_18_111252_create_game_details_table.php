<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained();
            $table->string('pawn1')->nullable();
            $table->string('pawn2')->nullable();
            $table->string('pawn3')->nullable();
            $table->string('pawn4')->nullable();
            $table->string('pawn5')->nullable();
            $table->string('pawn6')->nullable();
            $table->string('pawn7')->nullable();
            $table->string('pawn8')->nullable();

            $table->string('rook1')->nullable();
            $table->string('rook2')->nullable();

            $table->string('knight1')->nullable();
            $table->string('knight2')->nullable();

            $table->string('bishop1')->nullable();
            $table->string('bishop2')->nullable();

            $table->string('king')->nullable();

            $table->string('queen')->nullable();


            $table->string('pawn1_white')->nullable();
            $table->string('pawn2_white')->nullable();
            $table->string('pawn3_white')->nullable();
            $table->string('pawn4_white')->nullable();
            $table->string('pawn5_white')->nullable();
            $table->string('pawn6_white')->nullable();
            $table->string('pawn7_white')->nullable();
            $table->string('pawn8_white')->nullable();

            $table->string('rook1_white')->nullable();
            $table->string('rook2_white')->nullable();

            $table->string('knight1_white')->nullable();
            $table->string('knight2_white')->nullable();

            $table->string('bishop1_white')->nullable();
            $table->string('bishop2_white')->nullable();

            $table->string('king_white')->nullable();

            $table->string('queen_white')->nullable();

            $table->unsignedBigInteger('should_play')->nullable();
            $table->foreign('should_play')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_details');
    }
};
