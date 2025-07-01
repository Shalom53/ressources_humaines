<?php

namespace App\Repositories\Interfaces;

interface AnneeRepositoryInterface
{

    public function rechercheAnneeById($id);
    public function addAnnee(array $data);
    public function updateAnnee($id, array $data);
    public function deleteAnnee($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);


}
