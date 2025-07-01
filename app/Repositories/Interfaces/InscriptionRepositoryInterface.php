<?php

namespace App\Repositories\Interfaces;

interface InscriptionRepositoryInterface
{

    public function rechercheInscriptionById($id);
    public function addInscription(array $data);
    public function updateInscription($id, array $data);
    public function deleteInscription($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);

    public function getListeAvecTotalPaiement(array $filters);




}
