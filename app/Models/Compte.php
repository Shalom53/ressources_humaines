<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compte extends Model
{
    use HasFactory;

    protected $table = 'comptes';

    protected $fillable = [
        'email',
        'mot_passe',
        'statut_compte',
        'espace_id',
        'parent_id',
        'password_reset',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les comptes actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Lien vers l'espace familial
     */
    public function espace()
    {
        return $this->belongsTo(Espace::class);
    }

    /**
     * Lien vers le parent associé
     */
    public function parent()
    {
        return $this->belongsTo(ParentEleve::class, 'parent_id');
    }

    /**
     * Masquer le mot de passe à la sérialisation
     */
    protected $hidden = [
        'mot_passe',
    ];

    /**
     * Accesseur : statut du compte (libellé)
     */
    public function getStatutCompteLibelleAttribute()
    {
        return match ($this->statut_compte) {
            'actif' => 'Compte actif',
            'inactif' => 'Compte inactif',
            'suspendu' => 'Compte suspendu',
            default => 'Non défini',
        };
    }
}
