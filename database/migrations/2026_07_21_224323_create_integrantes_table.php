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
        Schema::create('integrantes', function (Blueprint $table) {
            $table->id();
            // Datos generales
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable(); // Hay personas con un solo apellido
            
            // Identificadores únicos 
            // Identificador Laboral Único (Clave Presupuestal / Número de Personal)
            // Se marca como unique porque una delegación no puede ser ocupada por dos registros
            $table->string('rfc', 13)->unique()->nullable()->index();
            $table->string('curp', 18)->unique()->nullable()->index();
            $table->string('numero_personal')->unique()->nullable()->index();            
            
            // Género basado en el estándar del padrón (M/H)
            $table->enum('genero', ['M', 'H']);
            
            // Contacto
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();

            // Relación con el catálogo de 12 ítems
            $table->foreignId('nivel_integrante_id')->constrained('nivel_integrantes');
            
            // Estatus Global (Afecta a todas sus delegacións en cascada si es necesario)
            // ACTIVO, INACTIVO (por renuncia/expulsión), FINADO
            $table->string('estatus_global')->default('ACTIVO')->index();
            
            $table->timestamps();
            $table->softDeletes(); // Auditoría: nunca borrar un registro, solo marcarlo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrantes');
    }
};
