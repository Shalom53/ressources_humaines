<?php
namespace App\Repositories;

use App\Models\Mouvement;
use App\Repositories\Interfaces\MouvementRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MouvementRepository extends BaseRepository implements MouvementRepositoryInterface
{
    public function __construct(Mouvement $mouvement)
    {
        $this->model = $mouvement;
    }


    
    


}
