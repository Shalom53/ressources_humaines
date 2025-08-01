<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voiture extends Model
{
    use HasFactory;

    protected $table = 'voitures';

    protected $fillable = [
        'marque',
        'plaque',
        'nombre_place',
        'annee_id',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les voitures actives
     */
    public function scopeActives($query)
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
}
