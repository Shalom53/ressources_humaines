<?php
namespace App\Repositories;

use App\Models\Voiture;
use App\Repositories\Interfaces\VoitureRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class VoitureRepository extends BaseRepository implements VoitureRepositoryInterface
{
    public function __construct(Voiture $voiture)
    {
        $this->model = $voiture;
    }


    
    


}
