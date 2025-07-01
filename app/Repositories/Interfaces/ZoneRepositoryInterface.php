<?php

namespace  App\Repositories\Interfaces;

interface ZoneRepositoryInterface
{

    public function rechercheZoneById($id);
    public function addZone(array $data);
    public function updateZone($id, array $data);
    public function deleteZone($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);




}
