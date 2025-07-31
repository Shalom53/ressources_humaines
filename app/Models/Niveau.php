<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Niveau extends Model
{
    use HasFactory;

    protected $table = 'niveaux';

    protected $fillable = [
        'libelle',
        'description',
        'numero_ordre',
        'cycle_id',
        'etat',
    ];

    /**
     * Relation avec le modèle Cycle (si la table `cycles` existe)
     */
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    /**
     * Scope pour ne récupérer que les niveaux actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }
}
