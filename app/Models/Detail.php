<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detail extends Model
{
    use HasFactory;

    protected $table = 'details';

    protected $fillable = [
        'montant',
        'libelle',
        'paiement_id',
        'type_paiement',
        'inscription_id',
        'frais_ecole_id',
        'statut_paiement',
        'annee_id',
        'souscription_id',
        'caisse_id',
        'comptable_id',
        'caissier_id',
        'date_paiement',
        'date_encaissement',
        'etat',
    ];

    /**
     * Scope pour récupérer les détails actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Paiement parent de ce détail
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Inscription liée à ce paiement
     */
    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    /**
     * Frais scolaire concerné
     */
    public function frais()
    {
        return $this->belongsTo(FraisEcole::class, 'frais_ecole_id');
    }

    /**
     * Année scolaire
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Souscription liée si applicable
     */
    public function souscription()
    {
        return $this->belongsTo(Souscription::class);
    }

    /**
     * Caisse ayant enregistré le paiement
     */
    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }

    /**
     * Comptable ayant traité le paiement
     */
    public function comptable()
    {
        return $this->belongsTo(Utilisateur::class, 'comptable_id');
    }

    /**
     * Caissier ayant encaissé
     */
    public function caissier()
    {
        return $this->belongsTo(Utilisateur::class, 'caissier_id');
    }
}
