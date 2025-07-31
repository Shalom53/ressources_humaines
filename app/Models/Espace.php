<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Espace extends Model
{
    use HasFactory;

    protected $table = 'espaces';

    protected $fillable = [
        'nom_famille',
        'annee_id',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les espaces actifs
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
     * Liste des élèves liés à cet espace
     */
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    /**
     * Liste des inscriptions liées à cet espace
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
