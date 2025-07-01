<?php

namespace App\Repositories\Interfaces;

interface ChauffeurRepositoryInterface
{

    public function rechercheChauffeurById($id);
    public function addChauffeur(array $data);
    public function updateChauffeur($id, array $data);
    public function deleteChauffeur($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);




}
