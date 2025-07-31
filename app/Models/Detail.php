<?php

namespace App\Models\Comptabilite;

use App\Types\TypeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
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


        'montant',
        'libelle',
        'paiement_id',
        
        'type_paiement',
        'inscription_id',
        'frais_ecole_id',
        'statut_paiement',
        'annee_id',
        'souscription_id',
        'caisse_id',
        'comptable_id',
        'caissier_id',
        'date_paiement',
        'date_encaissement',
        


        'etat',

    ];



    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }


     public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }


    public function fraisecole()
    {
        return $this->belongsTo(FraisEcole::class);
    }

     public function annee()
    {
        return $this->belongsTo(Annee::class);
    }

     public function souscription()
    {
        return $this->belongsTo(Souscription::class);
    }


    public function comptable()
    {
        return $this->belongsTo(Utilisateur::class);
    }


    public function caissier()
    {
        return $this->belongsTo(Utilisateur::class);
    }






}
