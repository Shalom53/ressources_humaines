<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Souscription extends Model
{
    use HasFactory;

    protected $table = 'souscriptions';

    protected $fillable = [
        'date_souscription',
        'montant_annuel_prevu',
        'taux_remise',
        'type_paiement',
        'frais_ecole_id',
        'niveau_id',
        'annee_id',
        'inscription_id',
        'description_domicile',
        'utilisateur_id',
        'zone_id',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les souscriptions actives
     */
    public function scopeActives($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Frais école lié
     */
    public function fraisEcole()
    {
        return $this->belongsTo(FraisEcole::class, 'frais_ecole_id');
    }

    /**
     * Niveau scolaire
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Année scolaire
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Inscription liée
     */
    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    /**
     * Utilisateur qui a enregistré la souscription
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    /**
     * Zone associée
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Accesseur pour le libellé du type de paiement
     */
    public function getTypePaiementLibelleAttribute()
    {
        $types = [
            1 => 'Mensuel',
            2 => 'Annuel',
            3 => 'Forfait',
        ];

        return $types[$this->type_paiement] ?? 'Inconnu';
    }
}
