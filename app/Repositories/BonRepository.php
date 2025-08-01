<?php
namespace App\Repositories;

use App\Models\Bon;
use App\Repositories\Interfaces\BonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BonRepository extends BaseRepository implements BonRepositoryInterface
{
    public function __construct(Bon $bon)
    {
        $this->model = $bon;
    }


    
    


}
