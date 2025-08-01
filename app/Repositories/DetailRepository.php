<?php
namespace App\Repositories;

use App\Models\Detail;
use App\Repositories\Interfaces\DetailRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DetailRepository extends BaseRepository implements DetailRepositoryInterface
{
    public function __construct(Detail $detail)
    {
        $this->model = $detail;
    }


    
    


}
