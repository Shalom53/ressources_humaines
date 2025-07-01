<?php

namespace App\Repositories\Interfaces;

interface CompteRepositoryInterface
{

    public function rechercheCompteById($id);
    public function addCompte(array $data);
    public function updateCompte($id, array $data);
    public function deleteCompte($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
   


}
