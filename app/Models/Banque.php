<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Personnels; 

class Banque extends Model
{
    protected $fillable = ['personnel_id', 'nom', 'numero_compte', 'etat'];

    public function personnel()
    {
        return $this->belongsTo(Personnels::class, 'personnel_id');
    }
}
