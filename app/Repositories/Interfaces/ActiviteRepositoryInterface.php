<?php

namespace App\Repositories\Interfaces;

interface ActiviteRepositoryInterface
{

    public function rechercheActiviteById($id);
    public function addActivite(array $data);
    public function updateActivite($id, array $data);
    public function deleteActivite($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);


}
