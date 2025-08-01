<?php
namespace App\Repositories;

use App\Models\Annee;
use App\Repositories\Interfaces\AnneeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AnneeRepository extends BaseRepository implements AnneeRepositoryInterface
{
    public function __construct(Annee $annee)
    {
        $this->model = $annee;
    }


    
    


}
