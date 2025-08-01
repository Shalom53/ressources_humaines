<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function liste();
    public function rechercher(int $id);
    public function ajouter(array $data);
    public function modifier(int $id, array $data);
    public function supprimer(int $id);
}
