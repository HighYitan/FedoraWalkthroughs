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
        Schema::create('game_releases', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del lanzamiento
            $table->date('release_date'); // Fecha de lanzamiento del juego
            $table->foreignId('game_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del juego al que pertenece el lanzamiento
            //$table->foreignId('platform_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID de la plataforma a la que pertenece el lanzamiento
            $table->foreignId('region_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID de la región a la que pertenece el lanzamiento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_releases');
    }
};
