<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Eleve extends Model
{
    use HasFactory;

    protected $table = 'eleves';

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'prenom_usuel',
        'ecole_provenance',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'nationalite_id',
        'espace_id',
        'nom_medecin',
        'personne_prevenir',
        'photo',
        'carte_identite',
        'naissance',

        // Infos santé
        'groupe_id',
        'certificat_medical',
        'vaccin_1',
        'vaccin_2',
        'vaccin_3',
        'vaccin_4',
        'vaccin_5',
        'numero_medecin',
        'numero_personne_prevenir',
        'lien_parente_personne',
        'naissance_eleve',
        'allergie',

        'etat',
    ];

    /**
     * Scope pour récupérer uniquement les élèves actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Relation avec la nationalité
     */
    public function nationalite()
    {
        return $this->belongsTo(Nationalite::class);
    }

    /**
     * Relation avec l'espace (ex: établissement, campus, etc.)
     */
    public function espace()
    {
        return $this->belongsTo(Espace::class);
    }

    /**
     * Relation avec le groupe sanguin
     */
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
}
