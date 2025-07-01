<?php

namespace App\Repositories\Interfaces;

interface CycleRepositoryInterface
{

    public function rechercheCycleById($id);
    public function addCycle(array $data);
    public function updateCycle($id, array $data);
    public function deleteCycle($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
    public function getListeAvecTotalNiveau(array $filters);



}
