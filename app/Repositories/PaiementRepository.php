<?php
namespace App\Repositories;

use App\Models\Paiement;
use App\Repositories\Interfaces\PaiementRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PaiementRepository extends BaseRepository implements PaiementRepositoryInterface
{
    public function __construct(Paiement $paiement)
    {
        $this->model = $paiement;
    }


    
    


}
