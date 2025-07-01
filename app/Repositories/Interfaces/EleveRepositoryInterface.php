<?php

namespace App\Repositories\Interfaces;

interface EleveRepositoryInterface
{

    public function rechercheEleveById($id);
    public function addEleve(array $data);
    public function updateEleve($id, array $data);
    public function deleteEleve($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
  



}
