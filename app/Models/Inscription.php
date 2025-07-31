<?php

namespace App\Models\Comptabilite;

use App\Types\TypeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    public function __construct(array $attributes=[])
    {
        parent::__construct($attributes);
        $this->etat=TypeStatus::ACTIF;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [


        'date_inscription',
        'eleve_id',
        'cycle_id',
        'niveau_id',
        'last_niveau_id',
        'classe_id',
        'espace_id',
        'type_inscription',
        'statut_validation',
        'espace_id',
        'parent_id',
        'taux_remise',
        'motif_rejet',
        'date_validation',
        'utilisateur_id',
        'specialite_id_1',
        'specialite_id_2',
        'specialite_id_3',
        'specialite_abandonne',
        'bulletin_1',
        'bulletin_2',
        'bulletin_3',
        'dnb',
        'programme_provenance',
        'is_cantine',
         'is_bus',
         'is_livre',
         'frais_scolarite',
         'frais_assurance',
         'frais_inscription',
         'frais_cantine',
         'frais_bus',
         'frais_livre',
         'remise_scolarite',
         'frais_examen',

        'etat',

       
    ];



    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }


     public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }


    public function niveau()
    {
        return $this->belongsTo(Nivau::class);
    }

     public function classe()
    {
        return $this->belongsTo(Classe::class);
    }


    public function lastniveau()
    {
        return $this->belongsTo(Niveau::class);
    }



    public function espace()
    {
        return $this->belongsTo(Espace::class);
    }

    





}
