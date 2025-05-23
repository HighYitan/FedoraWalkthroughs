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
        Schema::create('board_comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment', 5000); // Comentario del usuario
            $table->foreignId('board_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del tablero al que pertenece el comentario
            $table->foreignId('user_id')->constrained()->onUpdate('restrict')->onDelete('restrict'); // ID del usuario al que pertenece el comentario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_comments');
    }
};
