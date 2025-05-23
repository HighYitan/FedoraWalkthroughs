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
        Schema::create('guide_ratings', function (Blueprint $table) {
            $table->id();
            $table->decimal('rating', 4, 2)->default(0.00); // Allows values like 0.00, 7.50, 10.00, etc.
            $table->foreignId('guide_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();

            $table->unique(['guide_id', 'user_id']); // One rating per user per guide constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_ratings');
    }
};
