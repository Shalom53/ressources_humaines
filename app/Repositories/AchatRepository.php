<?php
namespace App\Repositories;

use App\Models\Achat;
use App\Repositories\Interfaces\AchatRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AchatRepository extends BaseRepository implements AchatRepositoryInterface
{
    public function __construct(Achat $achat)
    {
        $this->model = $achat;
    }


}
