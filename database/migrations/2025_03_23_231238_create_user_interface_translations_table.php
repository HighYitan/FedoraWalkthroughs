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
        Schema::create('user_interface_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del componente traducido
            $table->foreignId('user_interface_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('language_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_interface_translations');
    }
};
