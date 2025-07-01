<?php

namespace App\Repositories\Interfaces;

interface ChequeRepositoryInterface
{

    public function rechercheChequeById($id);
    public function addCheque(array $data);
    public function updateCheque($id, array $data);
    public function deleteCheque($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);




}
