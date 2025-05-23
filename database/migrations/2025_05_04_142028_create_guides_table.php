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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->decimal('rating', 4, 2)->nullable(); // Average rating of the guide (If no ratings, null)
            $table->boolean('is_approved')->default(false); // Boolean to check if the guide is approved to be seen
            $table->foreignId('game_release_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del juego al que pertenece la guía
            $table->foreignId('language_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del idioma al que pertenece la guía
            $table->foreignId('user_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del usuario al que pertenece la guía
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
