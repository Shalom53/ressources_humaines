<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cheque extends Model
{
    use HasFactory;

    protected $table = 'cheques';

    protected $fillable = [
        'numero',
        'emetteur',
        'annee_id',
        'paiement_id',
        'date_emission',
        'statut',
        'date_encaissement',
        'banque_id',
        'etat',
    ];

    /**
     * Scope pour récupérer uniquement les chèques actifs
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
     * Paiement associé au chèque
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Banque émettrice
     */
    public function banque()
    {
        return $this->belongsTo(Banque::class);
    }
}
