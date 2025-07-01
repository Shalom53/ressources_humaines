<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remuneration extends Model
{
    use HasFactory;

    protected $table = 'remunerations';

    protected $fillable = [
        'personnel_id',
        'salaire_brut',
        'total_retenue',
        'salaire_net',
        'etat',
    ];

    /**
     * Relation avec le modèle Personnel
     */
    public function personnel()
    {
        return $this->belongsTo(Personnels::class, 'personnel_id');
    }

    /**
     * Relation avec les primes (si tu as une table primes liée à cette table)
     */
    public function primes()
    {
        return $this->hasMany(Prime::class);
    }

    /**
     * Relation avec les retenues (si tu as une table retenues liées à cette table)
     */
    public function retenues()
    {
        return $this->hasMany(Retenue::class);
    }
}
