<?php
namespace App\Repositories;

use App\Models\Depense;
use App\Repositories\Interfaces\DepenseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepenseRepository extends BaseRepository implements DepenseRepositoryInterface
{
    public function __construct(Depense $depense)
    {
        $this->model = $depense;
    }


    
    


}
