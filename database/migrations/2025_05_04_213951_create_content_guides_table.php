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
        Schema::create('content_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Nombre de la sección de la guía
            $table->string('content', 10000); // Contenido de la sección de la guía
            $table->foreignId('guide_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID de la guía a la que pertenece la sección
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_guides');
    }
};
