<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Types\TypeStatus;
class Personnels extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = TypeStatus::ACTIF;
    }

    protected $fillable = [
        'nom',
        'prenom',
        'contact',
        'email',
        'date_naissance',
        'lieu_naissance',
        'prefecture_naissance',
        'sexe',
        'photo',
        'quartier_residentiel',
        'situation_familiale',
        'nombre_enfants',
        'situation_agent',
        'diplome_academique_plus_eleve',
        'intitule_diplome',
        'universite_obtention',
        'annee_obtention_diplome',
        'diplome_professionnel',
        'lieu_obtention_diplome_professionnel',
        'annee_obtention_diplome_professionnel',
        'nom_epoux_ou_epouse',
        'contact_epoux_ou_epouse',
        'date_prise_service',
        'statut',
        'qr_code',
        'mot_de_passe',
        'matricule',
        'etat',
    ];
    
    /**
     * Relations
     */
    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function retards()
    {
        return $this->hasMany(Retard::class);
    }

    public function congés()
    {
        return $this->hasMany(Conge::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class, 'personnel_id')->where('etat', 1);
    }


    public function documents()
    {
        return $this->hasMany(Document::class, 'personnel_id')->where('etat', 1);
    }

    
    public function contrat()
    {
        return $this->hasOne(Contrat::class, 'personnel_id')
            ->where('etat', 1)
            ->latestOfMany();
    }


    public function paies()
    {
        return $this->hasMany(Paie::class);
    }

    public function personneAPrevenir()
    {
        return $this->hasOne(PersonnesAPrevenir::class, 'personnel_id');
    }


    public function enseignant()
    {
        return $this->hasOne(PersonnelsEnseignant::class,'personnel_id');
    }

    public function administratif()
    {
        return $this->hasOne(PersonnelsAdministratif::class,'personnel_id');
    }

    
    public function sanctions()
    {
        return $this->hasMany(Sanction::class);
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

   public function paiements()
    {
        return $this->hasMany(PaiementEmploye::class, 'personnel_id'); 
    }




    public function remuneration()
    {
        return $this->hasOne(Remuneration::class, 'personnel_id');
    }






    public function billetage()
    {
        return $this->hasOne(\App\Models\Billetage::class, 'personnel_id');
    }

    public function banque()
    {
        return $this->hasOne(\App\Models\Banque::class, 'personnel_id');
    }


    public function pointages()
    {
        return $this->hasMany(Pointage::class, 'personnel_id');
    }



}
