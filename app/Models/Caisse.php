<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Caisse extends Model
{
    use HasFactory;

    protected $table = 'caisses';

    protected $fillable = [
        'libelle',
        'solde_initial',
        'solde_final',
        'date_ouverture',
        'date_cloture',
        'statut',
        'utilisateur_id',
        'responsable_id',
        'annee_id',
        'etat',
    ];

    /**
     * Scope pour récupérer uniquement les caisses actives
     */
    public function scopeActives($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Utilisateur qui a ouvert ou géré la caisse
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    /**
     * Responsable direct de la caisse
     */
    public function responsable()
    {
        return $this->belongsTo(Utilisateur::class, 'responsable_id');
    }

    /**
     * Année scolaire associée
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Liste des mouvements ou détails liés à la caisse
     */
    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    /**
     * Accessor pour connaître si la caisse est ouverte
     */
    public function getEstOuverteAttribute()
    {
        return is_null($this->date_cloture);
    }
}
