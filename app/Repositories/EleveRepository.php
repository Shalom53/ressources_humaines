<?php
namespace App\Repositories;

use App\Models\Eleve;
use App\Repositories\Interfaces\EleveRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EleveRepository extends BaseRepository implements EleveRepositoryInterface
{
    public function __construct(Eleve $eleve)
    {
        $this->model = $eleve;
    }


    
    


}
