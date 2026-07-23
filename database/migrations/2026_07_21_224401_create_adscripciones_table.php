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
        Schema::create('adscripciones', function (Blueprint $table) {
            $table->id();
            
            // Relación con la Entidad Persona
            $table->foreignId('integrante_id')->constrained('integrantes')->cascadeOnDelete();
            
            // Relación con la Delegación (Unidad Administrativa)
            $table->foreignId('delegacion_id')->constrained('delegaciones');
            
            // Relación con el Nivel del Integrante (Los 12 ítems: PREESCOLAR, PAAE, etc.)
            $table->foreignId('nivel_integrante_id')->constrained('nivel_integrantes');
            
            // Datos de la Función
            $table->string('funcion')->comment('Ej: DIRECTOR, DOCENTE, INTENDENTE');
            
            // Historial de Fechas
            $table->date('fecha_ingreso_sev')->nullable();
            $table->date('fecha_ingreso_sindicato')->nullable();
            
            // Estatus Local de la Adscripción
            // Permite que un integrante tenga una Delegación ACTIVA y otra en PENDIENTE_BAJA
            $table->string('estatus_adscripcion')->default('ACTIVO')->index();
            
            $table->timestamps();
            $table->softDeletes(); // Para bitácora de movimientos y auditoría
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adscripciones');
    }
};
