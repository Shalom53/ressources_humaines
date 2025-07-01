<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retenue extends Model
{
    protected $fillable = ['remuneration_id', 'libelle', 'montant', 'periode','etat'];

    public function remuneration()
    {
        return $this->belongsTo(Remuneration::class);
    }
}
