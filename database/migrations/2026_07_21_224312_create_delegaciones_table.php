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
        Schema::create('delegaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regiones');
            $table->string('delegacion')->unique(); // Ej: 'D-II-59'
            $table->string('sede'); // Ej: 'PANUCO'
            // Relación con el catálogo de 42 ítems
            $table->foreignId('nivel_delegacion_id')->constrained('nivel_delegaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegaciones');
    }
};
