<?php

namespace App\Repositories\Interfaces;

interface BanqueRepositoryInterface
{

    public function rechercheBanqueById($id);
    public function addBanque(array $data);
    public function updateBanque($id, array $data);
    public function deleteBanque($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
   



}
