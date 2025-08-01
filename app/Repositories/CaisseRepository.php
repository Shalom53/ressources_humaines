<?php
namespace App\Repositories;

use App\Models\Caisse;
use App\Repositories\Interfaces\CaisseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CaisseRepository extends BaseRepository implements CaisseRepositoryInterface
{
    public function __construct(Caisse $caisse)
    {
        $this->model = $caisse;
    }


    
    


}
