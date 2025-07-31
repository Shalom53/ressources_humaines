<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailAchat extends Model
{
    use HasFactory;

    protected $table = 'detail_achats';

    protected $fillable = [
        'achat_id',
        'produit_id',
        'annee_id',
        'quantite',
        'prix_unitaire',
        'montant_achat',
        'etat',
    ];

    /**
     * Scope : récupérer uniquement les détails actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Relation avec l'achat
     */
    public function achat()
    {
        return $this->belongsTo(Achat::class);
    }

    /**
     * Relation avec le produit
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Relation avec l'année
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Montant total (calculé si besoin)
     */
    public function getMontantCalculeAttribute()
    {
        return $this->quantite * $this->prix_unitaire;
    }
}
