<?php

namespace App\Helpers;

class SessionHelper
{
    public static function getAnneeEncoursId()
    {
        $annee = session('AnneeEncours');
        return data_get($annee, 'id');
    }

    public static function getUtilisateurConnecteId()
    {
        $utilisateur = session('LoginUser');
        return data_get($utilisateur, 'id');
    }
}
