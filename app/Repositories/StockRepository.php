<?php
namespace App\Repositories;

use App\Models\Stock;
use App\Repositories\Interfaces\StockRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StockRepository extends BaseRepository implements StockRepositoryInterface
{
    public function __construct(Stock $stock)
    {
        $this->model = $stock;
    }


    
    


}
