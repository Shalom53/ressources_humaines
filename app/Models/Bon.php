<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bon extends Model
{
    use HasFactory;

    protected $table = 'bons';

    protected $fillable = [
        'reference',
        'date_bon',
        'type',
        'nom_responsable',
        'nom_magasinier',
        'annee_id',
        'etat',
    ];

    /**
     * Scope : récupérer uniquement les bons actifs
     */
    public function scopeActifs($query)
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
     * Libellé du type de bon
     */
    public function getTypeLibelleAttribute()
    {
        return match ($this->type) {
            1 => 'Bon de sortie',
            2 => 'Bon d’entrée',
            3 => 'Bon de transfert',
            default => 'Non défini',
        };
    }

    /**
     * Formatage de la date du bon
     */
    public function getDateBonFormateeAttribute()
    {
        return $this->date_bon ? \Carbon\Carbon::parse($this->date_bon)->format('d/m/Y') : null;
    }

    /**
     * Lignes de produits liées à ce bon (si tu gères ça)
     */
    public function lignes()
    {
        return $this->hasMany(BonLigne::class);
    }
}
