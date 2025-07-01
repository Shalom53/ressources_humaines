<?php

namespace App\Repositories\Interfaces;

interface DetailRepositoryInterface
{

    public function rechercheDetailById($id);
    public function addDetail(array $data);
    public function updateDetail($id, array $data);
    public function deleteDetail($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
   



}
