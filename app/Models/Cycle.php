<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cycle extends Model
{
    use HasFactory;

    protected $table = 'cycles';

    protected $fillable = [
        'libelle',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les cycles actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Relation : un cycle peut avoir plusieurs niveaux
     */
    public function niveaux()
    {
        return $this->hasMany(Niveau::class);
    }

    /**
     * Relation : un cycle peut avoir plusieurs classes
     */
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }
}
