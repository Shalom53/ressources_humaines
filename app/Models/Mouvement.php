<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mouvement extends Model
{
    use HasFactory;

    protected $table = 'mouvements';

    protected $fillable = [
        'libelle',
        'beneficiaire',
        'motif',
        'date_mouvement',
        'montant',
        'type_mouvement',
        'caisse_id',
        'utilisateur_id',
        'paiement_id',
        'depense_id',
        'annee_id',
        'file',
        'statut_mouvement',
        'etat',
    ];

    /**
     * Scope pour récupérer les mouvements actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Caisse liée à ce mouvement
     */
    public function cai
