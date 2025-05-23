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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100); // Nombre del tablero
            $table->string('description', 5000); // Descripción del tablero
            $table->foreignId('game_release_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del lanzamiento al que pertenece el tablero
            $table->foreignId('language_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del lenguaje al que pertenece el tablero
            $table->foreignId('user_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del usuario al que pertenece el tablero
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
