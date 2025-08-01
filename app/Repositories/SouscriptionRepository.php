<?php
namespace App\Repositories;

use App\Models\Souscription;
use App\Repositories\Interfaces\SouscriptionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SouscriptionRepository extends BaseRepository implements SouscriptionRepositoryInterface
{
    public function __construct(Souscription $souscription)
    {
        $this->model = $souscription;
    }


    
    


}
