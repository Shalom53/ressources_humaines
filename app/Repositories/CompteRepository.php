<?php
namespace App\Repositories;

use App\Models\Compte;
use App\Repositories\Interfaces\CompteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompteRepository extends BaseRepository implements CompteRepositoryInterface
{
    public function __construct(Compte $compte)
    {
        $this->model = $compte;
    }


    
    


}
