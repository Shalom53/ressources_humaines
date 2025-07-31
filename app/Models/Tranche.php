<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tranche extends Model
{
    use HasFactory;

    protected $table = 'tranches';

    protected $fillable = [
        'libelle',
        'date_butoire',
        'frais_ecole_id',
        'type_frais',
        'taux',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les tranches actives
     */
    public function scopeActives($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Frais d'école associé à cette tranche
     */
    public function fraisEcole()
    {
        return $this->belongsTo(FraisEcole::class, 'frais_ecole_id');
    }

    /**
