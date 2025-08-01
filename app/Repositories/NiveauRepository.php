<?php
namespace App\Repositories;

use App\Models\Niveau;
use App\Repositories\Interfaces\NiveauRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NiveauRepository extends BaseRepository implements NiveauRepositoryInterface
{
    public function __construct(Niveau $Niveau)
    {
        $this->model = $Niveau;
    }


    
    


}
