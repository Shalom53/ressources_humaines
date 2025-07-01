<?php

namespace App\Repositories\Interfaces;

interface NiveauRepositoryInterface
{

    public function rechercheNiveauById($id);
    public function addNiveau(array $data);
    public function updateNiveau($id, array $data);
    public function deleteNiveau($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);
    public function getListeAvecTotalClasse(array $filters);



}
