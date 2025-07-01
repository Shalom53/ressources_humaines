<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Types\TypeStatus;
class DemandeEmploi extends Model
{
    use HasFactory;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = TypeStatus::ACTIF;
    }
    protected $table = 'demandes_emploi'; 

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'experience',
        'domaine',
        'cv',
        'lettre_motivation',
        'etat',
    ];
}

