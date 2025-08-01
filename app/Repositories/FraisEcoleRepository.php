<?php
namespace App\Repositories;

use App\Models\FraisEcole;
use App\Repositories\Interfaces\FraisEcoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FraisEcoleRepository extends BaseRepository implements FraisEcoleRepositoryInterface
{
    public function __construct(FraisEcole $frais_ecole)
    {
        $this->model = $frais_ecole;
    }


    
    


}
