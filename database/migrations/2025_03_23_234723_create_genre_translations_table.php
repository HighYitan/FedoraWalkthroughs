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
        Schema::create('genre_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Nombre del género traducido
            $table->string('description', 1000)->nullable(); // Descripción del género traducido
            $table->foreignId('genre_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('language_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_translations');
    }
};
