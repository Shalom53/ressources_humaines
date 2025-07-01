<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Types\TypeStatus;
use App\Models\Personnels;
class Sanction extends Model
{
    use HasFactory;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = TypeStatus::ACTIF;
    }
    // Spécifier la table si elle ne suit pas la convention de nommage
    protected $table = 'sanctions';

    // Définir les attributs qui peuvent être remplis
    protected $fillable = [
        'personnel_id',
        'motif',
        'date_debut',
        'date_fin',
        'type',
       
        'etat',
    ];

    // Relation avec le modèle Personnel
    public function personnel()
    {
        return $this->belongsTo(Personnels::class);
    }
}
