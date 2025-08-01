<?php
namespace App\Repositories;

use App\Models\ParentEleve;
use App\Repositories\Interfaces\ParentEleveRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ParentEleveRepository extends BaseRepository implements ParentEleveRepositoryInterface
{
    public function __construct(ParentEleve $parent_eleve)
    {
        $this->model = $parent_eleve;
    }


    
    


}
