<?php

namespace App\Repositories\Interfaces;

interface ClasseRepositoryInterface
{

    public function rechercheClasseById($id);
    public function addClasse(array $data);
    public function updateClasse($id, array $data);
    public function deleteClasse($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
  



}
