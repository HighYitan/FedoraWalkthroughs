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
        Schema::create('game_developers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del desarrollador al que pertenece el juego
            $table->foreignId('game_release_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del juego al que pertenece el desarrollador
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_developers');
    }
};
