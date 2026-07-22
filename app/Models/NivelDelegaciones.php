<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NivelDelegacion extends Model
{
    use HasFactory;

    protected $table = 'nivel_delegaciones';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Delegaciones que pertenecen a este nivel.
     */
    public function delegaciones(): HasMany
    {
        return $this->hasMany(Delegacion::class);
    }
}
