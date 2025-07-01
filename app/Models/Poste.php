<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Types\TypeStatus;
class Poste extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = TypeStatus::ACTIF;
    }

    // Spécifier la table si elle ne suit pas la convention de nommage (ici, on suppose que la table s'appelle 'postes')
    protected $table = 'postes';

    // Définir les attributs que vous pouvez remplir (fillable)
    protected $fillable = [
    'nom',
    'salaire_base',
    'salaire_horaire',
    'etat',
    ];


   
}
