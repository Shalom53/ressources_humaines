<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Types\TypeStatus;
class PersonnesAPrevenir extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = TypeStatus::ACTIF;
    }

    protected $table = 'personnes_a_prevenir';

    protected $fillable = [
        'nom',
        'prenom',
        'profession',
        'lien_parente',
        'adresse',
        'contact',
        'etat',
        'personnel_id',
    ];

    /**
     * Relation avec le modèle Personnel
     */
    public function personnel()
    {
        return $this->belongsTo(Personnels::class, 'personnel_id');
    }

}
