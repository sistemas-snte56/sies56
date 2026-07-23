<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NivelIntegrante extends Model
{
    use HasFactory;

    protected $table = 'nivel_integrantes';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Integrantes que pertenecen a este nivel.
     */
    public function integrantes(): HasMany
    {
        return $this->hasMany(Integrante::class);
    }

    /**
     * adscripciones asociadas directamente a este nivel.
     */
    public function adscripciones(): HasMany
    {
        return $this->hasMany(Adscripcion::class);
    }
}
