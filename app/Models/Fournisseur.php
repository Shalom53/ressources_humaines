<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;

    protected $table = 'fournisseurs';

    protected $fillable = [
        'raison_social',
        'nom_contact',
        'telephone_contact',
        'adresse',
        'etat',
    ];

    /**
     * Scope : récupérer uniquement les fournisseurs actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Relation avec les achats effectués auprès de ce fournisseur
     */
    public function achats()
    {
        return $this->hasMany(Achat::class);
    }

    /**
     * Nom complet du contact pour affichage
     */
    public function getContactCompletAttribute()
    {
        r
