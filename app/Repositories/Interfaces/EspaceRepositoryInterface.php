<?php

namespace App\Repositories\Interfaces;

interface EspaceRepositoryInterface
{

    public function rechercheEspaceById($id);
    public function addEspace(array $data);
    public function updateEspace($id, array $data);
    public function deleteEspace($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
   



}
