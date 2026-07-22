<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regiones';

    protected $fillable = [
        'nombre',
        'sede',
    ];

    /**
     * Delegaciones que pertenecen a esta región.
     */
    public function delegaciones(): HasMany
    {
        return $this->hasMany(Delegacion::class);
    }
}
