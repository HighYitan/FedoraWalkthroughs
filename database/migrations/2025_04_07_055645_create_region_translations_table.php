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
        Schema::create('region_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la región traducido
            $table->foreignId('region_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID de la región a la que pertenece la traducción
            $table->foreignId('language_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del idioma al que pertenece la traducción
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region_translations');
    }
};
