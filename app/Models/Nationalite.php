<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nationalite extends Model
{
    use HasFactory;

    protected $table = 'nationalites';

    protected $fillable = [
        'libelle',
        'etat',
    ];

    /**
     * Scope pour ne récupérer que les nationalités actives
     */
    public function scopeActives($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Élèves ayant cette nationalité
     */
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    /**
     * Parents ayant cette nationalité
     */
    public function parents()
    {
        return $this->hasMany(ParentEleve::class);
    }
}
