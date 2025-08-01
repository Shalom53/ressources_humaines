<?php
namespace App\Repositories;

use App\Models\DetailBon;
use App\Repositories\Interfaces\DetailBonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DetailBonRepository extends BaseRepository implements DetailBonRepositoryInterface
{
    public function __construct(DetailBon $detail_bon)
    {
        $this->model = $detail_bon;
    }


    
    


}
