<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'personnel_id',
        'date',
        'heure_arrive',
        'heure_depart',
        'retard',
    ];

    // Lorsqu'on définit l'heure d'arrivée, on met automatiquement le retard
    public static function boot()
    {
        parent::boot();

        static::saving(function ($presence) {
            if ($presence->heure_arrive >= '08:00:00') {
                $presence->retard = 'oui';
            } else {
                $presence->retard = 'non';
            }
        });
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
