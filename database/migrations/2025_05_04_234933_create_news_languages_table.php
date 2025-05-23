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
        Schema::create('news_languages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255); // Titulo de la noticia
            $table->string('content', 10000); // Contenido de la noticia
            $table->string('image', 255); // Imagen de la noticia
            $table->foreignId('news_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID de la noticia a la que pertenece el idioma
            $table->foreignId('language_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del idioma al que pertenece la noticia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_languages');
    }
};
