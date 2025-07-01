<?php

namespace App\Repositories\Interfaces;

interface PaiementRepositoryInterface
{

    public function recherchePaiementById($id);
    public function addPaiement(array $data);
    public function updatePaiement($id, array $data);
    public function deletePaiement($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);




}
