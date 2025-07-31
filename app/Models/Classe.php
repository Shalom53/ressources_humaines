<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'libelle',
        'emplacement',
        'cycle_id',
        'niveau_id',
        'annee_id',
        'etat',
    ];

    /**
     * Relation avec le Cycle
     */
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    /**
     * Relation avec le Niveau
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Relation avec l'Année
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Scope pour ne récupérer que les classes actives
     */
    public function scopeActives($query)
    {
        return $query->where('etat', 1);
    }
}
