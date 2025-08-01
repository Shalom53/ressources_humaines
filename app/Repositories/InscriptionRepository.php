<?php
namespace App\Repositories;

use App\Models\Inscription;
use App\Repositories\Interfaces\InscriptionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class InscriptionRepository extends BaseRepository implements InscriptionRepositoryInterface
{
    public function __construct(Inscription $inscription)
    {
        $this->model = $inscription;
    }


    
    


}
