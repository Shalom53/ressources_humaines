<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'reference',
        'payeur',
        'motif_suppression',
        'telephone_payeur',
        'date_paiement',
        'statut_paiement',
        'mode_paiement',
        'inscription_id',
        'utilisateur_id',
        'cheque_id',
        'annee_id',
        'etat',
    ];

    /**
     * Scope pour récupérer les paiements actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Relation avec l'inscription (paiement lié à une inscription)
     */
    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    /**
     * Relation avec l'utilisateur ayant enregistré le paiement
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    /**
     * Relation avec le chèque si paiement par chèque
     */
    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }

    /**
     * Relation avec l'année scolaire
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }
}
