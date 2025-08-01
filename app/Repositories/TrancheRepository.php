<?php
namespace App\Repositories;

use App\Models\Tranche;
use App\Repositories\Interfaces\TrancheRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TrancheRepository extends BaseRepository implements TrancheRepositoryInterface
{
    public function __construct(Tranche $tranche)
    {
        $this->model = $tranche;
    }


    
    


}
