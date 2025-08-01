<?php
namespace App\Repositories;

use App\Models\Nationalite;
use App\Repositories\Interfaces\NationaliteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NationaliteRepository extends BaseRepository implements NationaliteRepositoryInterface
{
    public function __construct(Nationalite $nationalite)
    {
        $this->model = $nationalite;
    }


    
    


}
