<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chauffeur extends Model
{
    use HasFactory;

    protected $table = 'chauffeurs';

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'annee_id',
        'etat',
    ];

    /**
     * Scope pour récupérer les chauffeurs actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Relation avec l'année scolaire
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Accessor pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return trim("{$this->prenom} {$this->nom}");
    }
}
