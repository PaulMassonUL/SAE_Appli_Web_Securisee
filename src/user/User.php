<?php

namespace netvod\user;

use netvod\video\Catalogue;

class User
{
    /**
     * email de l'utilisateur
     */
    private string $email;

    /**
     * mot de passe de l'utilisateur
     */
    private string $passwd;

    /**
     * catalogue de l'utilisateur
     */
    private Catalogue $catalogue;

    /**
     * liste de series preferées de l'utilisateur
     */
    private Catalogue $seriesPref;

    /**
     * @param $eml email
     * @param $pwd mot de passe
     */
    public function __construct($eml, $pwd)
    {
        $this->email = $eml;
        $this->passwd = $pwd;
    }

    /**
     * @return Catalogue
     */
    public function getCatalogue(): Catalogue
    {
        return $this->catalogue;
    }

    /**
     * @return Catalogue
     */
    public function getSeriesPref(): Catalogue
    {
        return $this->seriesPref;
    }

}