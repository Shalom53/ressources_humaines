<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentEleve extends Model
{
    use HasFactory;

    protected $table = 'parent_eleves';

    protected $fillable = [
        'nom_parent',
        'prenom_parent',
        'telephone',
        'profession',
        'espace_id',
        'is_principal',
        'role',
        'annee_id',
        'nationalite_id',
        'whatsapp',
        'quartier',
        'adresse',
        'email',
        'etat',
    ];

    /**
     * Scope pour récupérer les parents actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Relation avec l'espace (famille)
     */
    public function espace()
    {
        return $this->belongsTo(Espace::class);
    }

    /**
     * Relation avec l'année scolaire
     */
    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

    /**
     * Nationalité du parent
     */
    public function nationalite()
    {
        return $this->belongsTo(Nationalite::class);
    }

    /**
     * Inscriptions des enfants rattachés à ce parent
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'parent_id');
    }

    /**
     * Accesseur : nom complet
     */
    public function getNomCompletAttribute()
    {
        return trim("{$this->prenom_parent} {$this->nom_parent}");
    }
}
