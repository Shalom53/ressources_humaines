<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulletinPaie extends Model
{
    use HasFactory;

    protected $table = 'bulletins_paie';

    protected $fillable = [
        'reference',
        'periode',
        'personnel_id',
        'nom',
        'prenom',
        'adresse',
        'poste',
        'salaire_base',
        'salaire_horaire',
        'heures_supp',
        'logement',
        'commission',
        'transport',
        'conges',
        'prime_repos',
        'divers',
        'salaire_brut',
        'cnss',
        'ins',
        'irpp',
        'tcs',
        'credit',
        'absences',
        'avance_salaire',
        'acompte',
        'autre_retenue',
        'total_retenue',
        'salaire_net',
        'date_paiement',
    ];

    protected $casts = [
        'salaire_base' => 'float',
        'salaire_horaire' => 'float',
        'heures_supp' => 'float',
        'logement' => 'float',
        'commission' => 'float',
        'transport' => 'float',
        'conges' => 'float',
        'prime_repos' => 'float',
        'divers' => 'float',
        'salaire_brut' => 'float',
        'cnss' => 'float',
        'ins' => 'float',
        'irpp' => 'float',
        'tcs' => 'float',
        'credit' => 'float',
        'absences' => 'float',
        'avance_salaire' => 'float',
        'acompte' => 'float',
        'autre_retenue' => 'float',
        'total_retenue' => 'float',
        'salaire_net' => 'float',
        'date_paiement' => 'date',
    ];

    /**
     * Relation avec le modèle Personnel
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
