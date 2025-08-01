<?php
namespace App\Repositories;

use App\Models\Vente;
use App\Repositories\Interfaces\VenteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class VenteRepository extends BaseRepository implements VenteRepositoryInterface
{
    public function __construct(Vente $vente)
    {
        $this->model = $vente;
    }


    
    


}
