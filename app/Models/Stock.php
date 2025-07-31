<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = [
        'date_stock',
        'produit_id',
        'magasin_id',
        'annee_id',
        'quantite_initial',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les stocks actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Produit lié au stock
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Magasin dans lequel le stock est enregistré
     */
    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }

    /**
     * Année scolaire/gestion associée
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getDateStockFormateeAttribute()
    {
        return $this->date_stock ? \Carbon\Carbon::parse($this->date_stock)->format('d/m/Y') : null;
    }
}
