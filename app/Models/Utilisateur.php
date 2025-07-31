<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Utilisateur extends Model
{
    use HasFactory;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'prenom',
        'login',
        'email',
        'mot_passe',
        'photo',
        'role',
        'etat',
    ];

    /**
     * Scope pour récupérer uniquement les utilisateurs actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Accesseur pour afficher le nom complet
     */
    public function getNomCompletAttribute()
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    /**
     * Masquer les attributs sensibles lors de la sérialisation
     */
    protected $hidden = [
        'mot_passe',
    ];
}
