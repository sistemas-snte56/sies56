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
        Schema::table('users', function (Blueprint $table) {
            // Al ser 'nullable', permitimos que Admins y Coordinadores no sean integrantes.
            // 'nullOnDelete' asegura que si borras al integrante, el usuario no desaparece, solo queda desvinculado.
            $table->foreignId('integrante_id')
                ->after('id')
                ->nullable() 
                ->constrained('integrantes')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('integrante_id');
        });
    }
};
