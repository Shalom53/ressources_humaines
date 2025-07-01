<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'personnel_id',
        'fichier',
        'libelle',
    ];

    // Relation avec le modèle Personnel
    public function personnel()
    {
        return $this->belongsTo(Personnels::class);
    }
}
