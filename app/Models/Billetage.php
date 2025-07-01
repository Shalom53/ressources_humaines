<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Personnels; 

class Billetage extends Model
{
    use HasFactory;

    protected $table = 'billetages';

    protected $fillable = [
        'personnel_id',
        'montant_total',
        'statut',
        'etat',
    ];



public function personnel()
{
    return $this->belongsTo(Personnels::class, 'personnel_id');
}

}
