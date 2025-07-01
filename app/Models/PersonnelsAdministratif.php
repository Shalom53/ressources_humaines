<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Types\TypeStatus;
class PersonnelsAdministratif extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = TypeStatus::ACTIF;
    }

    protected $table = 'personnels_administratifs';

    protected $fillable = [
        
        'fonction_occupee',
        'service',
        
       
        'etat',
        'personnel_id',
        'personne_a_prevenir_id',
    ];

    /**
     * Relation avec le modèle Personnel
     */
    public function personnels()
    {
        return $this->belongsTo(Personnels::class);
    }

    /**
     * Relation avec le modèle PersonneAPrevenir
     */
    public function personnesAPrevenir()
    {
        return $this->belongsTo(PersonnesAPrevenir::class, 'personne_a_prevenir_id');
    }
}
