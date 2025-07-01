<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Contrat extends Model
{
    use HasFactory;

    protected $table = 'contrats';


    protected $fillable = [
        'personnel_id',
        'type',
        'Dure',
        'date_debut',
        'date_fin',
        'salaire',
        'description',
        'statut',
        'fichier',
        'etat',
    ];

    // Relation inverse avec Personnel
    public function personnel()
    {
        return $this->belongsTo(Personnels::class, 'personnel_id');
    }


    public function estValidePour($mois)
    {
        $debutMois = Carbon::createFromFormat('Y-m', $mois)->startOfMonth();
        $finMois = Carbon::createFromFormat('Y-m', $mois)->endOfMonth();
        $dateDebut = Carbon::parse($this->date_debut);
        $dateFin = $this->date_fin ? Carbon::parse($this->date_fin) : null;

        if ($this->etat != 1 || $this->statut !== 'actif') return false;

        if (strtolower($this->type) === 'cdi') {
            if ($dateDebut->gt($finMois)) return false;
            if ($dateDebut->between($debutMois->copy()->addDays(14), $finMois)) return false;
        } else {
            if ($dateFin && $dateFin->lt($debutMois)) return false;
            if ($dateDebut->between($debutMois->copy()->addDays(14), $finMois)) return false;
        }

        return true;
    }

}
