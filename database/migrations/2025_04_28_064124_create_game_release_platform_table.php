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
        Schema::create('game_release_platform', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_release_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del juego al que pertenece la plataforma
            $table->foreignId('platform_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID de la plataforma a la que pertenece el juego
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_release_platform');
    }
};
