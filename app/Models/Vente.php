<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vente extends Model
{
    use HasFactory;

    protected $table = 'ventes';

    protected $fillable = [
        'date_vente',
        'quantite',
        'annee_id',
        'inscription_id',
        'paiement_id',
        'produit_id',
        'detail_id',
        'utilisateur_id',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les ventes actives
     */
    public function scopeActives($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Année scolaire de la vente
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Élève inscrit ayant acheté
     */
    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    /**
     * Paiement lié à la vente
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Produit vendu
     */
    public function
