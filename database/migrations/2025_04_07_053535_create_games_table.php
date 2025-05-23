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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // Nombre del juego en minúsculas y sin espacios: the-legend-of-zelda, etc.
            //$table->foreignId('gnere_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del genero al que pertenece el juego
            //$table->foreignId('platform_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID de la plataforma a la que pertenece el juego
            //$table->foreignId('developer_id')->constrained("companies")->onUpdate('restrict')->onDelete('restrict');
            //$table->foreignId('publisher_id')->constrained("companies")->onUpdate('restrict')->onDelete('restrict');
            $table->decimal('rating', 4, 2)->nullable(); // Average rating of the game (If no ratings, null)
            $table->enum('featured', ["Y", "N"])->default("N");
            $table->string('image')->nullable(); // Link de la imagen del juego
            $table->string('video')->nullable(); // Link del video del juego
            $table->string('website')->nullable(); // Link del sitio web del juego o link a la wiki

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
