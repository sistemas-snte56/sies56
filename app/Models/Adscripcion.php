<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adscripcion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'adscripciones';

    protected $fillable = [
        'integrante_id',
        'delegacion_id',
        'nivel_integrante_id',
        'funcion',
        'fecha_ingreso_sev',
        'fecha_ingreso_sindicato',
        'estatus_adscripcion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso_sev' => 'date',
            'fecha_ingreso_sindicato' => 'date',
        ];
    }

    /**
     * Integrante al que pertenece esta adcripción.
     */
    public function integrante(): BelongsTo
    {
        return $this->belongsTo(Integrante::class);
    }

    /**
     * Delegación en la que está adscrito.
     */
    public function delegacion(): BelongsTo
    {
        return $this->belongsTo(Delegacion::class);
    }

    /**
     * Nivel del integrante en esta adcripción.
     */
    public function nivelIntegrante(): BelongsTo
    {
        return $this->belongsTo(NivelIntegrante::class);
    }    
}
