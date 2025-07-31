<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FraisEcole extends Model
{
    use HasFactory;

    protected $table = 'frais_ecoles';

    protected $fillable = [
        'libelle',
        'montant',
        'type_paiement',
        'type_forfait',
        'niveau_id',
        'annee_id',
        'type_produit',
        'prix_min',
        'prix_max',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les frais actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Niveau scolaire associé
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    /**
     * Année scolaire associée
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Détails de paiements liés à ce frais
     */
    public function details()
    {
        return $this->hasMany(Detail::class, 'frais_ecole_id');
    }

    /**
     * Accesseur pour libellé du type de paiement
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

    /**
     * Accesseur pour libellé du type de forfait
     */
    public function getTypeForfaitLibelleAttribute()
    {
        $types = [
            1 => 'Fixe',
            2 => 'Variable',
        ];

        return $types[$this->type_forfait] ?? 'Inconnu';
    }
}
