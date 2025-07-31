<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Types\TypeStatus;

class Annee extends Model
{
    use HasFactory;

    protected $table = 'annees';

    protected $fillable = [
        'libelle',
        'date_rentree',
        'date_fin',
        'date_ouverture_inscription',
        'date_fermeture_reinscription',
        'statut_annee',
        'etat',
    ];

    protected $casts = [
        'date_rentree' => 'date',
        'date_fin' => 'date',
        'date_ouverture_inscription' => 'date',
        'date_fermeture_reinscription' => 'date',
        'statut_annee' => 'integer',
        'etat' => 'integer',
    ];
}
