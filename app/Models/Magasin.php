<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Magasin extends Model
{
    use HasFactory;

    protected $table = 'magasins';

    protected $fillable = [
        'libelle',
        'responsable',
        'description',
        'etat',
    ];

    /**
     * Scope : récupérer uniquement les magasins actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('etat', 1);
    }

    /**
     * Stocks associés à ce magasin
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Nom affiché avec responsable
     */
    public function getNomCompletAttribute()
    {
        return $this->libelle . ' (Resp. : ' . $this->responsable . ')';
    }
}
