<?php
namespace App\Repositories;

use App\Models\Espace;
use App\Repositories\Interfaces\EspaceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EspaceRepository extends BaseRepository implements EspaceRepositoryInterface
{
    public function __construct(Espace $espace)
    {
        $this->model = $espace;
    }


    
    


}
