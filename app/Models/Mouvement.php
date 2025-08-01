<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mouvement extends Model
{
    use HasFactory;

    protected $table = 'mouvements';

    protected $fillable = [
        'libelle',
        'beneficiaire',
        'motif',
        'date_mouvement',
        'montant',
        'type_mouvement',
        'caisse_id',
        'utilisateur_id',
        'paiement_id',
        'depense_id',
        'annee_id',
        'file',
        'statut_mouvement',
        'etat',
    ];

    /**
     * Scope pour récupérer les mouvements actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Caisse liée à ce mouvement
     */
    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }

    /**
     * Utilisateur ayant enregistré le mouvement
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    /**
     * Paiement associé s'il s'agit d'une recette
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Dépense associée s'il s'agit d'une sortie
     */
    public function depense()
    {
        return $this->belongsTo(Depense::class);
    }

    /**
     * Année scolaire du mouvement
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Accesseur pour savoir si c'est un mouvement entrant ou sortant
     */
    public function getTypeLibelleAttribute()
    {
        return $this->type_mouvement == 1 ? 'Entrée' : 'Sortie';
    }
}
