<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delegacion extends Model
{
    use HasFactory;

    protected $table = 'delegaciones';

    protected $fillable = [
        'region_id',
        'delegacion',
        'sede',
        'nivel_delegacion_id',
    ];

    /**
     * Región a la que pertenece la delegación.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Nivel de la delegación.
     */
    public function nivelDelegacion(): BelongsTo
    {
        return $this->belongsTo(NivelDelegacion::class);
    }

    /**
     * adscripciones registradas en esta delegación.
     */
    public function adscripciones(): HasMany
    {
        return $this->hasMany(Adscripcion::class);
    }

    /**
     * Delegacion completa con región y nivel de delegación.
     */

    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->delegacion} {$this->sede } - {$this->nivelDelegacion->nombre}",
        );
    }
}
