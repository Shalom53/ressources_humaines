<?php
namespace App\Repositories;

use App\Models\Chauffeur;
use App\Repositories\Interfaces\ChauffeurRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ChauffeurRepository extends BaseRepository implements ChauffeurRepositoryInterface
{
    public function __construct(Chauffeur $chauffeur)
    {
        $this->model = $chauffeur;
    }


    
    


}
