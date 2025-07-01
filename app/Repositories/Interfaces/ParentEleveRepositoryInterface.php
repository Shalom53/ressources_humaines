<?php

namespace App\Repositories\Interfaces;

interface ParentEleveRepositoryInterface
{

    public function rechercheParentEleveById($id);
    public function addParentEleve(array $data);
    public function updateParentEleve($id, array $data);
    public function deleteParentEleve($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
   



}
