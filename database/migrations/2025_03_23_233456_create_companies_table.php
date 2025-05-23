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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique(); // Nombre de la empresa
            $table->integer('foundation_year')->nullable(); // Año de fundación
            $table->foreignId('country_id')->constrained('languages')->onUpdate('restrict')->onDelete('restrict'); // Relación con la tabla languages para mostrar su bandera (Si no hay el locale)
            $table->string('website')->nullable(); // Dirección web de la empresa
            $table->string('image')->nullable(); // Guarda la ruta de la imagen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
