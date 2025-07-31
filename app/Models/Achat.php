<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achat extends Model
{
    use HasFactory;

    protected $table = 'achats';

    protected $fillable = [
        'date_achat',
        'nom_acheteur',
        'reference',
        'bon_commande',
        'commentaire',
        'fournisseur_id',
        'annee_id',
        'statut_paiement',
        'statut_livraison',
        'etat',
    ];

    /**
     * Scope pour filtrer les achats actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Relation avec le fournisseur
     */
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    /**
     * Relation avec l'année
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Retourne le libellé du statut de paiement
     */
    public function getStatutPaiementLibelleAttribute()
    {
        return match ($this->statut_paiement) {
            1 => 'Payé',
            2 => 'Partiellement payé',
            3 => 'Non payé',
            default => 'Inconnu',
        };
    }

    /**
     * Retourne le libellé du statut de livraison
     */
    public function getStatutLivraisonLibelleAttribute()
    {
        return match ($this->statut_livraison) {
            1 => 'Livré',
            2 => 'Partiellement livré',
            3 => 'Non livré',
            default => 'Inconnu',
        };
    }

    /**
     * Relation avec les lignes d’achat (si tu as une table `detail_achats`)
     */
    public function details()
    {
        return $this->hasMany(DetailAchat::class);
    }
}
