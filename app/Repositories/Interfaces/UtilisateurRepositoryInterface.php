<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
interface UtilisateurRepositoryInterface
{

    /**
     * Vérifie si les identifiants sont valides.
     *
     * @param string $login
     * @param string $mot_passe
     * @return User|null
     */

    public function rechercheUtilisateurById($id);
    public function addUtilisateur(array $data);
    public function updateUtilisateur($id, array $data);
    public function deleteUtilisateur($id);

    public function getListe(array $filters);

    public function verifierIdentifiants(string $login, string $mot_passe): ?User;

    public function getTotal(array $filters);


}
