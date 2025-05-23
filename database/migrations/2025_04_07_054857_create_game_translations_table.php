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
        Schema::create('game_translations', function (Blueprint $table) {
            $table->id();
            $table->string('description', 5000)->nullable(); // Descripción del juego traducido
            $table->foreignId('game_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('language_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_translations');
    }
};
