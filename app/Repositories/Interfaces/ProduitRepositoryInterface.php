<?php

namespace App\Repositories\Interfaces;

interface ProduitRepositoryInterface
{

    public function rechercheProduitById($id);
    public function addProduit(array $data);
    public function updateProduit($id, array $data);
    public function deleteProduit($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);


}
