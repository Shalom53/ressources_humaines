<?php

namespace App\Repositories\Interfaces;

interface CaisseRepositoryInterface
{

    public function rechercheCaisseById($id);
    public function addCaisse(array $data);
    public function updateCaisse($id, array $data);
    public function deleteCaisse($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
   

}
