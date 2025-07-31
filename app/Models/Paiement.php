<?php

namespace App\Models\Comptabilite;

use App\Types\TypeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
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


        'reference',
        'payeur',
        'motif_suppression',
        
        'telephone_payeur',
        'date_paiement',
        'statut_paiement',
        'mode_paiement',
        'inscription_id',
        'utilisateur_id',
        'cheque_id',
        'annee_id',


        'etat',

    ];



    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }


     public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }


    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }

     public function annee()
    {
        return $this->belongsTo(Annee::class);
    }





}
