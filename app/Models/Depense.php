<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Depense extends Model
{
    use HasFactory;

    protected $table = 'depenses';

    protected $fillable = [
        'libelle',
        'beneficaire',
        'motif_depense',
        'date_depense',
        'montant',
        'annee_id',
        'utilisateur_id',
        'centre_depense_id',
        'ligne_budget_id',
        'budget_id',
        'statut_depense',
        'etat',
    ];

    /**
     * Scope pour récupérer uniquement les dépenses actives
     */
    public function scopeActives($query)
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
     * Utilisateur qui a enregistré la dépense
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    /**
     * Centre de dépense lié
     */
    public function centreDepense()
    {
        return $this->belongsTo(CentreDepense::class);
    }

    /**
     * Ligne budgétaire associée
     */
    public function ligneBudget()
    {
        return $this->belongsTo(LigneBudget::class);
    }

    /**
     * Budget principal
     */
    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
