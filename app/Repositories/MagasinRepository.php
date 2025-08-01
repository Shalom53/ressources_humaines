<?php
namespace App\Repositories;

use App\Models\Magasin;
use App\Repositories\Interfaces\MagasinRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MagasinRepository extends BaseRepository implements MagasinRepositoryInterface
{
    public function __construct(Magasin $magasin)
    {
        $this->model = $magasin;
    }


    
    


}
