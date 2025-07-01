<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engagement extends Model
{
    use HasFactory;

    protected $table = 'contrats';


protected $fillable = [
    'personnel_id',
    'type',
    'Dure',
    'date_debut',
    'date_fin',
    'salaire',
    'description',
    'statut',
    'fichier',
    'etat',
];

    // Relation inverse avec Personnel
    public function personnel()
    {
        return $this->belongsTo(Personnels::class, 'personnel_id');
    }
}
