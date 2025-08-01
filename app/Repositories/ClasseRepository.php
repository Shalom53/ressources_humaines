<?php
namespace App\Repositories;

use App\Models\Classe;
use App\Repositories\Interfaces\ClasseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ClasseRepository extends BaseRepository implements ClasseRepositoryInterface
{
    public function __construct(Classe $classe)
    {
        $this->model = $classe;
    }


    
    


}
