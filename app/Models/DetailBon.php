<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailBon extends Model
{
    use HasFactory;

    protected $table = 'detail_bons';

    protected $fillable = [
        'quantite',
        'bon_id',
        'annee_id',
        'produit_id',
        'libelle',
        'etat',
    ];

    /**
     * Scope : récupérer uniquement les lignes actives
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Bon auquel cette ligne appartient
     */
    public function bon()
    {
        return $this->belongsTo(Bon::class);
    }

    /**
     * Produit concerné par cette ligne
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Année scolaire ou budgétaire
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }
}
