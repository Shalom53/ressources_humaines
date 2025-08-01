<?php
namespace App\Repositories;

use App\Models\Cheque;
use App\Repositories\Interfaces\ChequeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ChequeRepository extends BaseRepository implements ChequeRepositoryInterface
{
    public function __construct(Cheque $Cheque)
    {
        $this->model = $Cheque;
    }


    
    


}
