<?php

namespace  App\Repositories\Interfaces;

interface VoitureRepositoryInterface
{

    public function rechercheVoitureById($id);
    public function addVoiture(array $data);
    public function updateVoiture($id, array $data);
    public function deleteVoiture($id);

    public function getListe(array $filters);

    public function getTotal(array $filters);




}
