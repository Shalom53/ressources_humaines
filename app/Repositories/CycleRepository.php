<?php
namespace App\Repositories;

use App\Models\Cycle;
use App\Repositories\Interfaces\CycleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CycleRepository extends BaseRepository implements CycleRepositoryInterface
{
    public function __construct(Cycle $cycle)
    {
        $this->model = $cycle;
    }


    
    


}
