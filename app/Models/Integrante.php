<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Integrante extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'integrantes';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'curp',
        'numero_personal',
        'genero',
        'telefono',
        'email',
        'nivel_integrante_id',
        'estatus_global',
    ];

    /**
     * Nivel al que pertenece el integrante.
     */
    public function nivelIntegrante(): BelongsTo
    {
        return $this->belongsTo(NivelIntegrante::class);
    }

    /**
     * Adcripciones (historial de asignaciones) del integrante.
     */
    public function adcripciones(): HasMany
    {
        return $this->hasMany(Adscripcion::class);
    }

    /**
     * Usuario del sistema asociado a este integrante (si tiene acceso).
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Nombre completo del integrante.
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }
}
