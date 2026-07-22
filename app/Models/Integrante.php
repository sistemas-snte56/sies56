<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
     * Accesor y mutador para el nombre del integrante, 
     * asegurando que se almacene en mayúsculas y sin espacios innecesarios.
     */

    protected function nombre(): Attribute
    {
        return Attribute::make(
            set : fn (?string $value) => $value
                ? mb_strtoupper(trim($value),'UTF-8')
                : null,
        );
    }    

    protected function apellidoPaterno(): Attribute
    {
        return Attribute::make(
            set : fn (?string $value) => $value
                ? mb_strtoupper(trim($value),'UTF-8')
                : null,
        );
    }    

    protected function apellidoMaterno(): Attribute
    {
        return Attribute::make(
            set : fn (?string $value) => $value
                ? mb_strtoupper(trim($value),'UTF-8')
                : null,
        );
    }    

    protected function rfc(): Attribute
    {
        return Attribute::make(
            set : fn (?string $value) => $value
                ? mb_strtoupper(trim($value),'UTF-8')
                : null,
        );
    }

    protected function curp(): Attribute
    {
        return Attribute::make(
            set : fn (?string $value) => $value
                ? mb_strtoupper(trim($value),'UTF-8')
                : null,
        );
    }

    /**
     * Nombre completo del integrante.
     */
    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => trim(
                "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}"
            ),
        );
    }
}
