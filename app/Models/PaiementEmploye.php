<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personnels;
class PaiementEmploye extends Model
{
    use HasFactory;

    protected $fillable = [
        'personnel_id',
        'montant',
        'date_paiement',
        'mode_paiement',
        'mois_paie',
        'note',
    ];

   public function personnel()
    {
        return $this->belongsTo(Personnels::class, 'personnel_id');
    }

}   
