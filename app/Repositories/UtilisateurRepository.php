<?php
namespace App\Repositories;

use App\Models\Utilisateur;
use App\Repositories\Interfaces\UtilisateurRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UtilisateurRepository extends BaseRepository implements UtilisateurRepositoryInterface
{
    public function __construct(Utilisateur $utilisateur)
    {
        $this->model = $utilisateur;
    }


    
    


}
